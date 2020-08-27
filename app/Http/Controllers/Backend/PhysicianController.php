<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Models\CountryModel;
use App\Models\DesignationMasterModel;
use App\Models\MedicineMasterModel;
use App\Models\PhysicianMembershipMasterModel;
use App\Models\Physician\PhysicianEduModel;
use App\Models\Physician\PhysicianExperienceModel;
use App\Models\Physician\PhysicianMembershipModel;
use App\Models\Physician\PhysicianProfessionModel;
use App\Models\Physician\PhysicianAdditionalEduModel;
use App\Models\Physician\PhysicianProfileModel;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Storage;
use \Carbon\Carbon;

class PhysicianController extends Controller
{
    protected $flashData = [
        'status' => 0,
        'message' => 'Something went wrong.Try again later.',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $users = User::role('physician')
                ->select(['id', 'first_name', 'last_name', 'email', 'active'])
                ->with('physicianProfile')
                ->bothInActive();

            return Datatables::of($users)
                ->addIndexColumn()
                ->addColumn('first_name', function ($row) {
                    return $row->first_name . ' ' . $row->last_name;
                })
                ->addColumn('gender', function ($row) {
                    return ucwords($row->physicianEducation->registration_no);
                })
                ->addColumn('contact', function ($row) {
                    $contact = '<i class="fa fa-envelope fa-fw"></i>' . $row->email;
                    $contact .= '<br><i class="fa fa-mobile fa-fw"></i>' . $row->physicianProfile->mobile_no;
                    if (!empty($row->physicianProfile->landline)) {
                        $contact .= '<br><i class="fa fa-phone fa-fw"></i>' . $row->physicianProfile->landline;
                    }
                    return $contact;
                })
                ->addColumn('photo', function ($row) {
                    if (!empty($row->physicianProfile->avatar)) {
                        return '<a href="' . url('storage/app/avatars/' . $row->physicianProfile->avatar) . '" target="new"><img class="" src="' . url('storage/app/avatars/' . $row->physicianProfile->avatar) . '" width="65" height="65">';
                    } else {
                        return '';
                    }
                })
                ->addColumn('actions', function ($row) {
                    if ($row->active == 1) {
                        $actions = '<a href="javascript:void(0);" title="Lock" class="btn btn-outline-dark changeStatus" data-rowurl="' . route('admin.physician.updateStatus', [$row->id, 0]) . '" data-row="' . $row->id . '"><i class="fa fa-fw fa-lock"></i></a> ';

                    } else if ($row->active == 0) {

                        $actions = '<a href="javascript:void(0);" title="Unlock" class="btn btn-outline-success changeStatus" data-rowurl="' . route('admin.physician.updateStatus', [$row->id, 1]) . '" data-row="' . $row->id . '"><i class="fa fa-fw fa-unlock-alt"></i></a> ';
                    }
                    $filtered = [];
                    $edu = $row->physicianeducation()->get();
                    if (count($edu) > 0) {
                        $filtered = $edu->filter(function ($value, $key) {
                            return trim(strtolower($value['branch_of_medicine'])) == 'homoeopathy';
                        });
                    }

                    $profFiltered = [];
                    $prof = $row->physicianProfession()->get();
                    if (count($prof) > 0) {
                        $profFiltered = $prof->filter(function ($value, $key) {
                            if (trim($value['sector']) == '1' && trim($value['clinic_type']) == '1') {
                                return true;
                            } else {
                                return false;
                            }
                        });
                    }

                    $actions .= ' <a title="Edit" href="' . route('admin.physician.edit', $row->id) . '" class="btn btn-outline-info"><i class="fa fa-fw fa-pencil"></i></a> ';
                    if (count($filtered) > 0 && count($profFiltered) > 0) {
                        $actions .= ' <a href="' . route('admin.physician.clinics.index', ['physician' => $row->id]) . '" title="View Clinics" class="btn btn-outline-info"><i class="fa fa-fw fa-hospital-o"></i></a>';
                    }
                    if ($row->physicianProfile->has_branches == 1) {
                        $actions .= ' <a title="View Branches" href="' . route('admin.physician.branches.index', ['physician' => $row->id]) . '" class="btn btn-outline-dark"><i class="fa fa-fw fa-bank"></i></a>';
                    }
                    $actions .= ' <a title="Delete" href="javascript:void(0);" data-rowurl="' . route('admin.physician.updateStatus', [$row->id, 2]) . '" data-row="' . $row->id . '" class="btn removeRow btn-outline-danger"><i class="fa fa-fw fa-trash"></i></a>';

                    return $actions;
                })
                ->rawColumns(['contact', 'actions', 'photo'])
                ->make(true);
        }

        return view('backend.physician.list_physicians');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageData['memberships'] = PhysicianMembershipMasterModel::activeOnly();
        $pageData['days'] = [
            'monday' => 'Monday',
            'tuesday' => 'Tuesday',
            'webnesday' => 'Wednesday',
            'thursday' => 'Thursday',
            'friday' => 'Friday',
            'saturday' => 'Saturday',
            'sunday' => 'Sunday',
        ];
        $pageData['countries'] = CountryModel::activeOnly();
        $pageData['designations'] = DesignationMasterModel::activeOnly();
        $pageData['brMedicines'] = MedicineMasterModel::activeOnly();

        return view('backend.physician.create_physicians', $pageData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //User Creation
        $user = User::create([
            'first_name' => trim($request->firstname),
            'last_name' => trim($request->lastname),
            'email' => trim($request->email_address),
            'password' => Hash::make(trim($request->confirm_password)),
            'confirmed' => 1,
        ]);

        //assign role
        $user->assignRole('physician');

        //profile creation
        $avatarName = $locationMap = '';

        if ($request->has('image')) {
            $avatarName = $user->id . '_' . time() . '.' . $request->file('image')->extension();
            Storage::putFileAs(
                'avatars', $request->file('image'), $avatarName
            );
        }
        if ($request->has('loc_image')) {
            $locationMap = $user->id . '_' . time() . '.' . $request->file('loc_image')->extension();
            Storage::putFileAs(
                'location_images', $request->file('loc_image'), $locationMap
            );
        }

        $data = $avatarName;

        PhysicianProfileModel::create([
            'user_id' => $user->id,
            'avatar' => $avatarName,
            'gender' => trim($request->gender),
            'dob' => \Carbon\Carbon::parse(trim($request->dob))->format('Y-m-d'),
            'age' => \Carbon\Carbon::parse(trim($request->dob))->age,
            'district' => trim($request->district),
            'state' => trim($request->state),
            'country' => trim($request->country),
            'pincode' => trim($request->pincode),
            'landmark' => trim($request->landmark),
            'mobile_no' => trim($request->mobile_no),
            'landline' => trim($request->landno) != '' ? $request->landno : null,
            'address' => trim($request->address),
            'about_me' => trim($request->about_me),
            'has_branches' => trim($request->clinic_br_detail),
            'map_image' => $locationMap, //trim($request->about_me),
            //'qr_code' => ''//trim($request->about_me),
            'latitude_longitude' => trim($request->latitude) . '*' . trim($request->longitude),
        ]);

        //Add Education
        for($m=1;$m<=$request->main_row;$m++)
        {
            if($request->has('branch_of_medicine_'.$m))
            {
                $parEdu = PhysicianEduModel::create([
                    'user_id' => $user->id,
                    'branch_of_medicine' => trim($request->input('branch_of_medicine_'.$m)),
                    'registration_no' => trim($request->input('registration_no_'.$m)),
                    'medical_council' => trim($request->input('medical_council_'.$m)),
                    'professional_qualification' => trim($request->input('professional_qualification_'.$m)),
                    'college_name' => trim($request->input('prof_college_'.$m)),
                    'join_year' => trim($request->input('prof_joinyear_'.$m)),
                    'place' => trim($request->input('prof_place_'.$m)),
                ]);

                //for additional row
                $addRow = $request->input('edu_rows_'.$m);

                for($ad=1;$ad<=$addRow;$ad++)
                {
                    if($request->has('add_prof_branch_' .$m. $ad))
                    {
                        PhysicianAdditionalEduModel::create([
                            'user_id' => $user->id,
                            'parent_edu_id' => $parEdu->id,
                            'branch' => trim($request->input('add_prof_branch_'.$m . $ad)),
                            'professional_qualification' => trim($request->input('additional_qualification_'.$m . $ad)),
                            'college' => trim($request->input('add_prof_college_'.$m . $ad)),
                            'join_year' => trim($request->input('add_prof_joinyear_'.$m . $ad)),
                            'place' => trim($request->input('add_prof_place_'.$m . $ad)),
                        ]);
                    }
                }
            }
        }

        //Profession
        for ($i = 1; $i <= trim($request->prof_rows); $i++) {
            if ($request->has('prof_desig_' . $i)) {
                PhysicianProfessionModel::create([
                    'user_id' => $user->id,
                    'sector' => $request->input('sector_' . $i),
                    'clinic_type' => $request->input('clinic_detail_' . $i),
                    'description' => serialize([
                        'designation' => $request->input('prof_desig_' . $i),
                        'organization' => $request->input('prof_org_' . $i),
                        'place' => $request->input('prof_palce_' . $i),
                        'since' => $request->input('prof_since_' . $i),
                    ]),
                ]);
            }
        }

        //Experience
        for ($i = 1; $i <= trim($request->exp_rows); $i++) {
            if ($request->has('exp_desig_' . $i)) {
                PhysicianExperienceModel::create([
                    'user_id' => $user->id,
                    'designation' => $request->input('exp_desig_' . $i),
                    'institution' => $request->input('exp_wrkat_' . $i),
                    'place' => $request->input('exp_place_' . $i),
                    'working_years' => $request->input('exp_fryr_' . $i) . '*' . $request->input('exp_toyr_' . $i),
                    'homoeo_experience_years' => $request->input('exp_homoeo_' . $i),
                ]);
            }
        }

        //Memberships
        for ($i = 1; $i <= trim($request->mem_rows); $i++) {
            if ($request->has('mem_' . $i) && !empty($request->input('mem_' . $i))) {
                PhysicianMembershipModel::create([
                    'user_id' => $user->id,
                    'record_type' => 'membership',
                    'description' => $request->input('mem_' . $i),
                ]);
            }
        }

        //Achievements
        for ($i = 1; $i <= trim($request->ach_rows); $i++) {
            if ($request->has('ach_' . $i) && !empty($request->input('ach_' . $i))) {
                PhysicianMembershipModel::create([
                    'user_id' => $user->id,
                    'record_type' => 'achievement',
                    'description' => $request->input('ach_' . $i),
                ]);
            }
        }

        $this->flashData = [
            'status' => 1,
            'message' => 'Successfully new physician has been created',
        ];

        $request->session()->flash('flashData', $this->flashData);

        return redirect()->route('admin.physician.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pageData['brMedicines'] = MedicineMasterModel::activeOnly();
        $pageData['memberships'] = PhysicianMembershipMasterModel::activeOnly();
        $pageData['days'] = [
            'monday' => 'Monday',
            'tuesday' => 'Tuesday',
            'webnesday' => 'Wednesday',
            'thursday' => 'Thursday',
            'friday' => 'Friday',
            'saturday' => 'Saturday',
            'sunday' => 'Sunday',
        ];
        $pageData['userData'] = User::find($id);
        $pageData['countries'] = CountryModel::activeOnly();
        $pageData['states'] = CountryModel::find($pageData['userData']->physicianProfile->country);
        $pageData['states'] = $pageData['states'] ? $pageData['states']->states : [];
        $pageData['designations'] = DesignationMasterModel::activeOnly();

        return view('backend.physician.edit_physicians', $pageData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        //User updation
        User::where('id', $id)->update([
            'first_name' => trim($request->firstname),
            'last_name' => trim($request->lastname),
        ]);

        //profile updation
        $getProfile = PhysicianProfileModel::where('user_id', $id)->first();
        $avatarName = $getProfile->avatar;
        $locationMap = $getProfile->map_image;

        if ($request->has('image')) {
            $avatarName = $id . '_' . time() . '.' . $request->file('image')->extension();
            Storage::putFileAs(
                'avatars', $request->file('image'), $avatarName
            );
        }
        $data = $avatarName;

        if ($request->has('loc_image')) {
            $locationMap = $id . '_' . time() . '.' . $request->file('loc_image')->extension();
            Storage::putFileAs(
                'location_images', $request->file('loc_image'), $locationMap
            );
        }

        PhysicianProfileModel::where('user_id', $id)->update([
            'avatar' => $avatarName,
            'gender' => trim($request->gender),
            'dob' => \Carbon\Carbon::parse(trim($request->dob))->format('Y-m-d'),
            'age' => \Carbon\Carbon::parse(trim($request->dob))->age,
            'district' => trim($request->district),
            'state' => trim($request->state),
            'country' => trim($request->country),
            'pincode' => trim($request->pincode),
            'landmark' => trim($request->landmark),
            'mobile_no' => trim($request->mobile_no),
            'landline' => trim($request->landno) != '' ? $request->landno : null,
            'address' => trim($request->address),
            'about_me' => trim($request->about_me),
            'has_branches' => trim($request->clinic_br_detail),
            'map_image' => $locationMap,
            //'qr_code' => ''//trim($request->about_me),
            'latitude_longitude' => trim($request->latitude) . '*' . trim($request->longitude),
        ]);

        //Delete additional edu
        PhysicianEduModel::where('user_id', $id)->delete();
        PhysicianAdditionalEduModel::where('user_id', $id)->delete();
        for($m=1;$m<=$request->main_row;$m++)
        {
            if($request->has('branch_of_medicine_'.$m))
            {
                $parEdu = PhysicianEduModel::create([
                    'user_id' => $id,
                    'branch_of_medicine' => trim($request->input('branch_of_medicine_'.$m)),
                    'registration_no' => trim($request->input('registration_no_'.$m)),
                    'medical_council' => trim($request->input('medical_council_'.$m)),
                    'professional_qualification' => trim($request->input('professional_qualification_'.$m)),
                    'college_name' => trim($request->input('prof_college_'.$m)),
                    'join_year' => trim($request->input('prof_joinyear_'.$m)),
                    'place' => trim($request->input('prof_place_'.$m)),
                ]);

                //for additional row
                $addRow = $request->input('edu_rows_'.$m);

                for($ad=1;$ad<=$addRow;$ad++)
                {
                    if($request->has('add_prof_branch_' .$m. $ad))
                    {
                        PhysicianAdditionalEduModel::create([
                            'user_id' => $id,
                            'parent_edu_id' => $parEdu->id,
                            'branch' => trim($request->input('add_prof_branch_'.$m . $ad)),
                            'professional_qualification' => trim($request->input('additional_qualification_'.$m . $ad)),
                            'college' => trim($request->input('add_prof_college_'.$m . $ad)),
                            'join_year' => trim($request->input('add_prof_joinyear_'.$m . $ad)),
                            'place' => trim($request->input('add_prof_place_'.$m . $ad)),
                        ]);
                    }
                }
            }
        }

        //Profession
        PhysicianProfessionModel::where('user_id', $id)->delete();
        for ($i = 1; $i <= trim($request->prof_rows); $i++) {
            if ($request->has('prof_desig_' . $i)) {
                PhysicianProfessionModel::create([
                    'user_id' => $id,
                    'sector' => $request->input('sector_' . $i),
                    'clinic_type' => $request->input('clinic_detail_' . $i),
                    'description' => serialize([
                        'designation' => $request->input('prof_desig_' . $i),
                        'organization' => $request->input('prof_org_' . $i),
                        'place' => $request->input('prof_palce_' . $i),
                        'since' => $request->input('prof_since_' . $i),
                    ]),
                ]);
            }
        }

        //Experience
        PhysicianExperienceModel::where('user_id', $id)->delete();
        for ($i = 1; $i <= trim($request->exp_rows); $i++) {
            if ($request->has('exp_desig_' . $i)) {
                PhysicianExperienceModel::create([
                    'user_id' => $id,
                    'designation' => $request->input('exp_desig_' . $i),
                    'institution' => $request->input('exp_wrkat_' . $i),
                    'place' => $request->input('exp_place_' . $i),
                    'working_years' => $request->input('exp_fryr_' . $i) . '*' . $request->input('exp_toyr_' . $i),
                    'homoeo_experience_years' => $request->input('exp_homoeo_' . $i),
                ]);
            }
        }

        //Memberships
        PhysicianMembershipModel::where([
            ['user_id', '=', $id],
            ['record_type', '=', 'membership'],
        ])->delete();
        for ($i = 1; $i <= trim($request->mem_rows); $i++) {
            if ($request->has('mem_' . $i) && !empty($request->input('mem_' . $i))) {
                PhysicianMembershipModel::create([
                    'user_id' => $id,
                    'record_type' => 'membership',
                    'description' => $request->input('mem_' . $i),
                ]);
            }
        }

        //Achievements
        PhysicianMembershipModel::where([
            ['user_id', '=', $id],
            ['record_type', '=', 'achievement'],
        ])->delete();
        for ($i = 1; $i <= trim($request->ach_rows); $i++) {
            if ($request->has('ach_' . $i) && !empty($request->input('ach_' . $i))) {
                PhysicianMembershipModel::create([
                    'user_id' => $id,
                    'record_type' => 'achievement',
                    'description' => $request->input('ach_' . $i),
                ]);
            }
        }

        $this->flashData = [
            'status' => 1,
            'message' => 'Successfully physician details has been updated',
        ];

        $request->session()->flash('flashData', $this->flashData);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function checkAddress(Request $request)
    {
        $exists = true;
        if (User::where([
            ['email', '=', trim($request->email_address)],
        ])->count() > 0) {
            $exists = false;
        }
        return response()->json($exists);
    }

    public function updateStatus(Request $request, $userId, $statusCode)
    {
        $result = User::where('id', trim($userId))
            ->update([
                'active' => trim($statusCode),
            ]);

        if ($result) {
            $this->flashData = [
                'status' => 1,
                'message' => $statusCode == 2 ? 'Successfully user has been removed' : 'Successfully status has been changed',
            ];

            $request->session()->flash('flashData', $this->flashData);
        }

        return response()->json([
            'status' => 1,
        ]);
    }
}
