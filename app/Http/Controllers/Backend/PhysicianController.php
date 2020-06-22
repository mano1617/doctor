<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Auth\User;
use Illuminate\Support\Facades\Hash;
use DataTables;
use DB;
use Storage;
use \Carbon\Carbon;
use App\Models\Physician\PhysicianProfileModel;
use App\Models\Physician\PhysicianProfessionModel;
use App\Models\Physician\PhysicianExperienceModel;
use App\Models\PhysicianMembershipMasterModel;
use App\Models\Physician\PhysicianMembershipModel;
use App\Models\Physician\PhysicianEduModel;
use App\Models\CountryModel;

class PhysicianController extends Controller
{
    protected $flashData = [
        'status' => 0,
        'message' => 'Something went wrong.Try again later.'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if($request->ajax())
        {
            $users = User::role('physician')
                ->select(['id','first_name','last_name','email', 'active'])
                ->with('physicianProfile')
                ->bothInActive();

            return Datatables::of($users)
                ->addIndexColumn()
                ->addColumn('first_name', function($row)
                {
                    return $row->first_name.' '.$row->last_name;
                })
                ->addColumn('gender', function($row)
                {
                    return ucwords($row->physicianProfile->gender);
                })
                ->addColumn('contact', function($row)
                {
                     $contact = '<i class="fa fa-envelope fa-fw"></i>'.$row->email;
                     $contact .= '<br><i class="fa fa-mobile fa-fw"></i>'.$row->physicianProfile->mobile_no;
                     if(!empty($row->physicianProfile->landline)){
                        $contact .= '<br><i class="fa fa-phone fa-fw"></i>'.$row->physicianProfile->landline;
                     }
                     return $contact;
                })
                ->addColumn('photo', function($row)
                {
                    if(!empty($row->physicianProfile->avatar))
                    {
                        return '<a title="'.$row->physicianProfile->avatar.'" href="'.url('storage/app/avatars/'.$row->physicianProfile->avatar).'" target="new"><img class="" src="'.url('storage/app/avatars/'.$row->physicianProfile->avatar).'" width="65" height="65">';
                    }else{
                        return '';
                    }
                })
                ->addColumn('actions', function($row)
                {
                    if($row->active==1)
                    {
                        $actions = '<a href="javascript:void(0);" title="Lock" class="btn btn-outline-dark changeStatus" data-rowurl="'.route('admin.physician.updateStatus',[$row->id,0]).'" data-row="'.$row->id.'"><i class="fa fa-fw fa-lock"></i></a> ';

                    }else if($row->active==0){

                        $actions = '<a href="javascript:void(0);" title="Unlock" class="btn btn-outline-success changeStatus" data-rowurl="'.route('admin.physician.updateStatus',[$row->id,1]).'" data-row="'.$row->id.'"><i class="fa fa-fw fa-unlock-alt"></i></a> ';
                    }

                    $actions .= '<a title="Edit" href="'.route('admin.physician.edit',$row->id).'" class="btn btn-outline-info"><i class="fa fa-fw fa-pencil"></i></a> ';
                    $actions .= '<a href="'.route('admin.physician.clinics.index',['physician' => $row->id]).'" title="View Clinics" class="btn btn-outline-info"><i class="fa fa-fw fa-hospital-o"></i></a>';
                    $actions .= ' <a title="View Branches" href="'.route('admin.physician.branches.index',['physician' => $row->id]).'" class="btn btn-outline-dark"><i class="fa fa-fw fa-plus-square"></i></a>';
                    $actions .= ' <a title="Delete" href="javascript:void(0);" data-rowurl="'.route('admin.physician.updateStatus',[$row->id,2]).'" data-row="'.$row->id.'" class="btn removeRow btn-outline-danger"><i class="fa fa-fw fa-trash"></i></a>';
                    
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
            'sunday' => 'Sunday'
        ];
        $pageData['countries'] = CountryModel::activeOnly();

        return view('backend.physician.create_physicians',$pageData);
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
            'confirmed' => 1
        ]);

        //assign role
        $user->assignRole('physician');

        //profile creation
        $avatarName = $locationMap = '';

        if($request->has('image'))
        {
            $avatarName = $user->id.'_'.time().'.'.$request->file('image')->extension();
            Storage::putFileAs(
                'avatars', $request->file('image'), $avatarName
            );
        }
        if($request->has('loc_image'))
        {
            $locationMap = $user->id.'_'.time().'.'.$request->file('loc_image')->extension();
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
            'landline' => trim($request->landno)!='' ? $request->landno : null,
            'address' => trim($request->address),
            'about_me' => trim($request->about_me),
            'has_branches' => 0,//trim($request->about_me),
            'map_image' => $locationMap,//trim($request->about_me),
            //'qr_code' => ''//trim($request->about_me),
        ]);
        

        //edu
        for($i=1; $i<=trim($request->edu_rows); $i++)
        {
            if($request->has('branch_of_medicine_'.$i))
            {
            PhysicianEduModel::create([
            'user_id' => $user->id,
            'branch_of_medicine' => trim($request->input('branch_of_medicine_'.$i)),
            'registration_no' => trim($request->input('registration_no_'.$i)),
            'medical_council' => trim($request->input('medical_council_'.$i)),
            'professional_qualification' => trim($request->input('professional_qualification_'.$i)),
            'additional_qualification' => trim($request->input('additional_qualification_'.$i))
        ]);
            }
        }

        //Profession
        for($i=1; $i<=trim($request->prof_rows); $i++)
        {
            if($request->has('prof_desig_'.$i))
            {
                PhysicianProfessionModel::create([
                    'user_id' => $user->id,
                    'sector' => $request->input('sector_'.$i),
                    'clinic_type' => $request->input('clinic_detail_'.$i),
                    'description' => serialize([
                        'designation' => $request->input('prof_desig_'.$i),
                        'organization' => $request->input('prof_org_'.$i),
                        'place' => $request->input('prof_palce_'.$i),
                        'since' => $request->input('prof_since_'.$i),
                    ])
                ]);
            }
        }

        //Experience
        for($i=1; $i<=trim($request->exp_rows); $i++)
        {
            if($request->has('exp_desig_'.$i))
            {
                PhysicianExperienceModel::create([
                    'user_id' => $user->id,
                    'designation' => $request->input('exp_desig_'.$i),
                    'institution' => $request->input('exp_wrkat_'.$i),
                    'place' => $request->input('exp_place_'.$i),
                    'working_years' => $request->input('exp_fryr_'.$i).'*'.$request->input('exp_toyr_'.$i),
                    'homoeo_experience_years' => $request->input('exp_homoeo_'.$i),
                ]);
            }
        }

        //Memberships
        for($i=1; $i<=trim($request->mem_rows); $i++)
        {
            if($request->has('mem_'.$i) && !empty($request->input('mem_'.$i)))
            {
                PhysicianMembershipModel::create([
                    'user_id' => $user->id,
                    'record_type' => 'membership',
                    'description' => $request->input('mem_'.$i)
                ]);
            }
        }

        //Achievements
        for($i=1; $i<=trim($request->ach_rows); $i++)
        {
            if($request->has('ach_'.$i) && !empty($request->input('ach_'.$i)))
            {
                PhysicianMembershipModel::create([
                    'user_id' => $user->id,
                    'record_type' => 'achievement',
                    'description' => $request->input('ach_'.$i)
                ]);
            }
        }

        $this->flashData = [
            'status' => 1,
            'message' => 'Successfully user has been registered'
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
        $pageData['memberships'] = PhysicianMembershipMasterModel::activeOnly();
        $pageData['days'] = [
            'monday' => 'Monday',
            'tuesday' => 'Tuesday',
            'webnesday' => 'Wednesday',
            'thursday' => 'Thursday',
            'friday' => 'Friday',
            'saturday' => 'Saturday',
            'sunday' => 'Sunday'
        ];
        $pageData['userData'] = User::find($id);
        $pageData['countries'] = CountryModel::activeOnly();

        return view('backend.physician.edit_physicians',$pageData);
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
        User::where('id',$id)->update([
            'first_name' => trim($request->firstname),
            'last_name' => trim($request->lastname),
            // 'password' => Hash::make(trim($request->confirm_password)),
        ]);

        //profile updation
        $getProfile = PhysicianProfileModel::where('user_id',$id)->first();
        $avatarName = $getProfile->avatar;
        $locationMap = $getProfile->map_image;

        if($request->has('image'))
        {
            $avatarName = $id.'_'.time().'.'.$request->file('image')->extension();
            Storage::putFileAs(
                'avatars', $request->file('image'), $avatarName
            );
        }
        $data = $avatarName;

        if($request->has('loc_image'))
        {
            $locationMap = $id.'_'.time().'.'.$request->file('loc_image')->extension();
            Storage::putFileAs(
                'location_images', $request->file('loc_image'), $locationMap
            );
        }
        
        PhysicianProfileModel::where('user_id',$id)->update([
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
            'landline' => trim($request->landno)!='' ? $request->landno : null,
            'address' => trim($request->address),
            'about_me' => trim($request->about_me),
            'has_branches' => 0,//trim($request->about_me),
            'map_image' => $locationMap,
            //'qr_code' => ''//trim($request->about_me),
        ]);

        //Edu Update
        PhysicianEduModel::where('user_id',$id)->delete();
        for($i=1; $i<=trim($request->edu_rows); $i++)
        {
            if($request->has('branch_of_medicine_'.$i))
            {
                PhysicianEduModel::create([
                    'user_id' => $id,
                    'branch_of_medicine' => trim($request->input('branch_of_medicine_'.$i)),
                    'registration_no' => trim($request->input('registration_no_'.$i)),
                    'medical_council' => trim($request->input('medical_council_'.$i)),
                    'professional_qualification' => trim($request->input('professional_qualification_'.$i)),
                    'additional_qualification' => trim($request->input('additional_qualification_'.$i))
                ]);
            }
        }

        //Profession
        PhysicianProfessionModel::where('user_id',$id)->delete();
        for($i=1; $i<=trim($request->prof_rows); $i++)
        {
            if($request->has('prof_desig_'.$i))
            {
                PhysicianProfessionModel::create([
                    'user_id' => $id,
                    'sector' => $request->input('sector_'.$i),
                    'clinic_type' => $request->input('clinic_detail_'.$i),
                    'description' => serialize([
                        'designation' => $request->input('prof_desig_'.$i),
                        'organization' => $request->input('prof_org_'.$i),
                        'place' => $request->input('prof_palce_'.$i),
                        'since' => $request->input('prof_since_'.$i),
                    ])
                ]);
            }
        }

        //Experience
        PhysicianExperienceModel::where('user_id',$id)->delete();
        for($i=1; $i<=trim($request->exp_rows); $i++)
        {
            if($request->has('exp_desig_'.$i))
            {
                PhysicianExperienceModel::create([
                    'user_id' => $id,
                    'designation' => $request->input('exp_desig_'.$i),
                    'institution' => $request->input('exp_wrkat_'.$i),
                    'place' => $request->input('exp_place_'.$i),
                    'working_years' => $request->input('exp_fryr_'.$i).'*'.$request->input('exp_toyr_'.$i),
                    'homoeo_experience_years' => $request->input('exp_homoeo_'.$i),
                ]);
            }
        }

        //Memberships
        PhysicianMembershipModel::where([
            ['user_id','=',$id],
            ['record_type','=', 'membership']
        ])->delete();
        for($i=1; $i<=trim($request->mem_rows); $i++)
        {
            if($request->has('mem_'.$i) && !empty($request->input('mem_'.$i)))
            {
                PhysicianMembershipModel::create([
                    'user_id' => $id,
                    'record_type' => 'membership',
                    'description' => $request->input('mem_'.$i)
                ]);
            }
        }

        //Achievements
        PhysicianMembershipModel::where([
            ['user_id','=',$id],
            ['record_type','=', 'achievement']
        ])->delete();
        for($i=1; $i<=trim($request->ach_rows); $i++)
        {
            if($request->has('ach_'.$i) && !empty($request->input('ach_'.$i)))
            {
                PhysicianMembershipModel::create([
                    'user_id' => $id,
                    'record_type' => 'achievement',
                    'description' => $request->input('ach_'.$i)
                ]);
            }
        }

        $this->flashData = [
            'status' => 1,
            'message' => 'Successfully detail has been updated'
        ];

        $request->session()->flash('flashData', $this->flashData);

        return redirect()->route('admin.physician.index');
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
        if(User::where([
            ['email','=',trim($request->email_address)]
        ])->count()>0)
        {
            $exists = false;
        }
        return response()->json($exists);
    }

    public function updateStatus(Request $request, $userId, $statusCode)
    {
        $result = User::where('id', trim($userId))
            ->update([
                'active' => trim($statusCode)
            ]);

        if($result)
        {
            $this->flashData = [
                'status' => 1,
                'message' => $statusCode == 2 ? 'Successfully user has been removed' : 'Successfully status has been changed'
            ];

            $request->session()->flash('flashData', $this->flashData);
        }

        return response()->json([
            'status' => 1
        ]);
    }
}
