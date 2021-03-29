<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Models\DistrictModel;
use App\Models\CountryModel;
use App\Models\DesignationMasterModel;
use App\Models\MedicineMasterModel;
use App\Models\ProfessionQualifyModel;
use App\Models\PhysicianMembershipMasterModel;
use App\Models\Physician\PhysicianAdditionalEduModel;
use App\Models\Physician\PhysicianEduModel;
use App\Models\Physician\PhysicianExperienceModel;
use App\Models\Physician\PhysicianMembershipModel;
use App\Models\Physician\PhysicianProfessionModel;
use App\Models\Physician\PhysicianProfileModel;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Storage;
use \Carbon\Carbon;

class MedicalStudentController extends Controller
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
            $users = User::role('medical-student')
                ->select(['id', 'first_name', 'last_name', 'email', 'active'])
                ->with('physicianProfile')
                ->bothInActive();

            return Datatables::of($users)
                ->addIndexColumn()
                ->addColumn('first_name', function ($row) {
                    return trim(ucwords($row->physicianProfile->name_prefix).'.'.$row->first_name . ' ' . $row->last_name);
                })
                ->addColumn('medicine', function ($row) {
                    return $row->studentEducation->branch ? $row->studentEducation->branch->name : '';
                })
                ->addColumn('gender', function ($row) {
                    return ucwords($row->physicianProfile->gender);
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
                        $actions = '<a href="javascript:void(0);" title="Lock" class="btn btn-outline-dark changeStatus" data-rowurl="' . route('admin.medical-student.updateStatus', [$row->id, 0]) . '" data-row="' . $row->id . '"><i class="fa fa-fw fa-lock"></i></a> ';

                    } else if ($row->active == 0) {

                        $actions = '<a href="javascript:void(0);" title="Unlock" class="btn btn-outline-success changeStatus" data-rowurl="' . route('admin.medical-student.updateStatus', [$row->id, 1]) . '" data-row="' . $row->id . '"><i class="fa fa-fw fa-unlock-alt"></i></a> ';
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

                    $actions .= ' <a title="Edit" href="' . route('admin.medical-student.edit', $row->id) . '" class="btn btn-outline-info"><i class="fa fa-fw fa-pencil"></i></a> ';
                    if (count($filtered) > 0 && count($profFiltered) > 0) {
                        $actions .= ' <a href="' . route('admin.medical-student.clinics.index', ['physician' => $row->id]) . '" title="View Clinics" class="btn btn-outline-info"><i class="fa fa-fw fa-hospital-o"></i></a>';
                    }
                    if ($row->physicianProfile->has_branches == 1) {
                        $actions .= ' <a title="View Branches" href="' . route('admin.medical-student.branches.index', ['physician' => $row->id]) . '" class="btn btn-outline-dark"><i class="fa fa-fw fa-bank"></i></a>';
                    }
                    $actions .= ' <a title="Delete" href="javascript:void(0);" data-rowurl="' . route('admin.medical-student.updateStatus', [$row->id, 2]) . '" data-row="' . $row->id . '" class="btn removeRow btn-outline-danger"><i class="fa fa-fw fa-trash"></i></a>';

                    return $actions;
                })
                ->rawColumns(['contact', 'actions', 'photo'])
                ->make(true);
        }

        return view('backend.medical_student.list_students');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageData['memberships'] = PhysicianMembershipMasterModel::activeOnly();
        $pageData['countries'] = CountryModel::where('id',101)->activeOnly();
        $pageData['states'] = CountryModel::find(101);
        $pageData['states'] = $pageData['states'] ? $pageData['states']->states : [];
        $pageData['branchOfMedicine'] = MedicineMasterModel::select(['id', 'name'])->activeOnly();
        $pageData['cities'] = DistrictModel::activeOnly();

        return view('backend.physician.create_student', $pageData);
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
            'email' => trim($request->email_address),
            'password' => Hash::make(randomString(8)),
            'confirmed' => 1,
        ]);

        //assign role
        $user->assignRole('medical-student');

        //profile creation
        $avatarName = '';

        if ($request->has('image')) {
            $avatarName = $user->id . '_' . time() . '.' . $request->file('image')->extension();
            Storage::putFileAs(
                'avatars', $request->file('image'), $avatarName
            );
        }

        PhysicianProfileModel::create([
            'name_prefix' => trim($request->title),
            'user_id' => $user->id,
            'avatar' => $avatarName,
            'gender' => trim($request->gender),
            'age' => $request->age,
            'district' => trim($request->district),
            'state' => trim($request->state),
            'country' => trim($request->country),
            'pincode' => trim($request->pincode),
            'mobile_no' => trim($request->mobile_no),
            'address' => trim($request->address),
            'about_me' => trim($request->about_me)!='' ? trim($request->about_me) : null,
        ]);

        //Add Education
        for ($m = 1; $m <= $request->main_row; $m++) {
            if ($request->has('edu_branch_of_medicine_' . $m)) {

                $memberships = [];
                for ($i = 1; $i <= $request->input('edu_mem_rows_'.$m); $i++) {
                    if ($request->has('edu_mem_' . $m .'_'. $i)) {
                        if (trim($request->input('edu_mem_' . $m .'_'. $i))!='') {
                        array_push($memberships, $request->input('edu_mem_' . $m .'_'. $i));
                        }
                    }
                }

                $achives = [];
                for ($i = 1; $i <= $request->input('edu_ach_rows_'.$m); $i++) {
                    if ($request->has('edu_ach_' . $m .'_'. $i)) {
                        if (trim($request->input('edu_ach_' . $m .'_'. $i))!='') {
                            array_push($achives, $request->input('edu_ach_' . $m .'_'. $i));
                        }
                    }
                }

                PhysicianEduModel::create([
                    'user_id' => $user->id,
                    'branch_of_medicine' => trim($request->input('edu_branch_of_medicine_' . $m)),
                    'registration_no' => serialize($memberships),
                    'medical_council' => serialize($achives),
                    'professional_qualification' => trim($request->input('edu_year_' . $m)),
                    'college_name' => trim($request->input('edu_college_' . $m)),
                    'join_year' => trim($request->input('edu_joinyear_' . $m)),
                    'place' => trim($request->input('edu_place_' . $m)),
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
            'message' => 'Successfully new student has been created',
        ];

        $request->session()->flash('flashData', $this->flashData);

        return redirect()->route('admin.medical-student.index');

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
        $pageData['memberships'] = PhysicianMembershipMasterModel::activeOnly();
        $pageData['countries'] = CountryModel::activeOnly();
        $pageData['branchOfMedicine'] = MedicineMasterModel::select(['id', 'name'])->activeOnly();

        $pageData['userData'] = User::find($id);
        $pageData['countries'] = CountryModel::where('id',101)->activeOnly();
        $pageData['states'] = CountryModel::find($pageData['userData']->physicianProfile->country);
        $pageData['states'] = $pageData['states'] ? $pageData['states']->states : [];
        $pageData['cities'] = DistrictModel::activeOnly();

        return view('backend.medical_student.edit_student', $pageData);
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

        $data = User::find($id);

        //User updation
        User::where('id', $id)->update([
            'first_name' => trim($request->firstname),
        ]);

        //profile creation
        $avatarName = $data->physicianProfile->avatar;

        if ($request->has('image')) {
            $avatarName = $id . '_' . time() . '.' . $request->file('image')->extension();
            Storage::putFileAs(
                'avatars', $request->file('image'), $avatarName
            );
        }

        PhysicianProfileModel::where([
            ['user_id', '=', $id]
        ])->update([
            'name_prefix' => trim($request->title),
            'avatar' => $avatarName,
            'gender' => trim($request->gender),
            'age' => $request->age,
            'district' => trim($request->district),
            'state' => trim($request->state),
            'country' => trim($request->country),
            'pincode' => trim($request->pincode),
            'mobile_no' => trim($request->mobile_no),
            'address' => trim($request->address),
            'about_me' => trim($request->about_me)!='' ? trim($request->about_me) : null,
        ]);

        PhysicianEduModel::where('user_id',$id)->delete();
        //Add Education
        for ($m = 1; $m <= $request->main_row; $m++) {
            if ($request->has('edu_branch_of_medicine_' . $m)) {

                $memberships = [];
                for ($i = 1; $i <= $request->input('edu_mem_rows_'.$m); $i++) {
                    if ($request->has('edu_mem_' . $m .'_'. $i)) {
                        if (trim($request->input('edu_mem_' . $m .'_'. $i))!='') {
                        array_push($memberships, $request->input('edu_mem_' . $m .'_'. $i));
                        }
                    }
                }

                $achives = [];
                for ($i = 1; $i <= $request->input('edu_ach_rows_'.$m); $i++) {
                    if ($request->has('edu_ach_' . $m .'_'. $i)) {
                        if (trim($request->input('edu_ach_' . $m .'_'. $i))!='') {
                            array_push($achives, $request->input('edu_ach_' . $m .'_'. $i));
                        }
                    }
                }

                PhysicianEduModel::create([
                    'user_id' => $id,
                    'branch_of_medicine' => trim($request->input('edu_branch_of_medicine_' . $m)),
                    'registration_no' => serialize($memberships),
                    'medical_council' => serialize($achives),
                    'professional_qualification' => trim($request->input('edu_year_' . $m)),
                    'college_name' => trim($request->input('edu_college_' . $m)),
                    'join_year' => trim($request->input('edu_joinyear_' . $m)),
                    'place' => trim($request->input('edu_place_' . $m)),
                ]);
            }
        }

        PhysicianMembershipModel::where([
            ['user_id','=',$id],
            ['record_type','=','achievement']    
        ])->delete();
        //Achievements
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
            'message' => 'Successfully user details has been updated',
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
