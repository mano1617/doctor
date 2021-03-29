<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HospitalModel;
use App\Models\Auth\User;
use App\Models\CountryModel;
use App\Models\DistrictModel;
use App\Models\Physician\PhysicianClinicConsultsModel;
use App\Models\Physician\PhysicianClinicTimesModel;
use App\Models\StateModel;
use App\Models\Backend\HospitalConsultantModel;
use App\Models\Physician\PhysicianMembershipModel;
use DataTables;
use Illuminate\Database\Eloquent\Builder;
use Storage;
use Auth;

class HospitalController extends Controller
{
    protected $flashData = [
        'status' => 0,
        'message' => 'Something went wrong.Try again later.',
    ];

    protected $weekDays = [
        'monday' => 'Monday',
        'tuesday' => 'Tuesday',
        'wednesday' => 'Wednesday',
        'thursday' => 'Thursday',
        'friday' => 'Friday',
        'saturday' => 'Saturday',
        'sunday' => 'Sunday',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $physicianId = $request->has('physician') ? trim($request->physician) : false;
            $clinics = HospitalModel::select([
                'id', 'name', 'address', 'mobile_no', 'profile_image', 'email_address', 'district', 'state', 'country', 'pincode', 'landmark', 'website', 'status',
            ])
                ->Where(function ($query) use ($physicianId) {
                    if ($physicianId != false) {
                        $query->where('user_id', $physicianId);
                    }
                })
                ->where([
                    ['status', '!=', '2'],
                ])->latest()->get();

            return Datatables::of($clinics)
                ->addIndexColumn()
                ->addColumn('contact', function ($row) {
                    $contact = '<p>'.$row->address.'</p>';
                    $contact .= '<i class="fa fa-envelope fa-fw"></i>' . $row->email_address;
                    $contact .= '<br><i class="fa fa-mobile fa-fw"></i>' . $row->mobile_no;
                    if (!empty($row->landline)) {
                        $contact .= '<br><i class="fa fa-phone fa-fw"></i>' . $row->landline;
                    }
                    return $contact;
                })
                ->addColumn('photo', function ($row) {
                    if(!empty($row->profile_image))
                    {
                        return '<a href="'.url('storage/app/avatars/'.$row->profile_image).'" target="new"><img class="" src="'.url('storage/app/avatars/'.$row->profile_image).'" width="65" height="65">';
                    }else{
                        return '';
                    }
                })
                ->addColumn('actions', function ($row) use ($physicianId) {
                    if ($row->status == '1') {
                        $actions = '<a href="javascript:void(0);" class="btn btn-outline-dark changeStatus" data-rowurl="' . route('admin.hospitals.updateStatus', [$row->id, 0]) . '" data-row="' . $row->id . '"><i class="fa fa-fw fa-lock"></i></a> ';

                    } else if ($row->status == '0') {

                        $actions = '<a href="javascript:void(0);" class="btn btn-outline-success changeStatus" data-rowurl="' . route('admin.hospitals.updateStatus', [$row->id, 1]) . '" data-row="' . $row->id . '"><i class="fa fa-fw fa-unlock-alt"></i></a> ';
                    }

                    $actions .= '<a href="' . route('admin.hospitals.edit', $row->id) . '"  class="btn btn-outline-info"><i class="fa fa-fw fa-pencil"></i></a> ';
                    $actions .= '<a href="javascript:void(0);" id="viewConsult_btn_' . $row->id . '" data-rowId ="' . $row->id . '" title="View Consultants" class="btn btn-outline-info viewConsultant"><i class="fa fa-fw fa-users"></i></a>';
                    $actions .= ' <a title="View Gallery" href="javascript:void(0);" id="viewGallery_btn_' . $row->id . '" data-rowId ="' . $row->id . '"class="btn btn-outline-dark viewGallery"><i class="fa fa-fw fa-photo"></i></a>';
                    $actions .= ' <a href="javascript:void(0);" data-rowurl="' . route('admin.hospitals.updateStatus', [$row->id, 2]) . '" data-row="' . $row->id . '" class="btn removeRow btn-outline-danger"><i class="fa fa-fw fa-trash"></i></a>';

                    return $actions;
                })
                ->rawColumns(['contact', 'actions', 'photo'])
                ->make(true);
        }
        $pageData['days'] = $this->weekDays;

        return view('backend.list_hospitals', $pageData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageData['days'] = $this->weekDays;
        $pageData['countries'] = CountryModel::where('id',101)->activeOnly();
        $pageData['physicians'] = User::select(['id', 'first_name', 'last_name'])->role('physician')
            ->with('physicianProfession')
            ->whereHas('physicianProfession', function (Builder $query) {
                $query->where([
                    ['sector', '=', 1],
                    ['clinic_type', '=', 1],
                ]);
            })
            ->whereHas('physicianeducation', function (Builder $query) {
                $query->whereHas('branch', function (Builder $query) {
                    $query->whereRaw("LOWER(`lmr_mstr_branch_medicine`.`name`) = 'homoeopathy'");
                });
            })->orderBy('first_name')->get();

        $pageData['cities'] = DistrictModel::where('state_id', 18)->activeOnly();
        $pageData['states'] = CountryModel::find(101);
        $pageData['states'] = $pageData['states'] ? $pageData['states']->states : [];

        return view('backend.create_hospital', $pageData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $numbers = [];
        for($i=1;$i<=$request->rows;$i++)
        {
            if(trim($request->input('cnt_name_'.$i))!='' && trim($request->input('cnt_number_'.$i))!='')
            {
                array_push($numbers,[
                    'name' => $request->input('cnt_name_'.$i),
                    'number' => $request->input('cnt_number_'.$i)
                ]);
            }
        }

        $photo = '';
        if ($request->has('photo')) {
            $photo = Auth::id() . '_' . time() . '.' . $request->file('photo')->extension();
            Storage::putFileAs(
                'avatars', $request->file('photo'), $photo
            );
        }

        $desc = isset($request->wrk_times_others) ? trim($request->cli_wrk_others) : '';

        //Clinic creation
        $createClinic = HospitalModel::create([
            'user_id' => Auth::id(),
            'name' => trim($request->name),
            'since' => trim($request->since),
            'address' => trim($request->cli_address),
            'district' => trim($request->cli_district),
            'state' => trim($request->cli_state),
            'country' => trim($request->cli_country),
            'pincode' => trim($request->cli_pincode),
            'email_address' => trim($request->cli_email),
            'website' => trim($request->cli_website),
            'mobile_no' => trim($request->cli_mobile_no),
            'about_us' => trim($request->cli_about_us),
            'landmark' => trim($request->cli_landmark),
            'other_description' => trim($desc),
            'profile_image' => $photo,
            'contact_numbers' => serialize($numbers),
            'is_branch' => $request->clinic_br_detail
        ]);

        //Achievements
        for ($i = 1; $i <= trim($request->ach_rows); $i++) {
            if ($request->has('ach_' . $i) && !empty($request->input('ach_' . $i))) {
                PhysicianMembershipModel::create([
                    'user_id' => Auth::id(),
                    'record_type' => $createClinic->id,
                    'description' => $request->input('ach_' . $i),
                ]);
            }
        }

        foreach ($this->weekDays as $dayKey => $day) {
            $cliWorkDay = [
                'user_id' =>  Auth::id(),
                'clinic_id' => $createClinic->id,
                'clinic_type' => 'hospital',
                'day_name' => $dayKey,
                'morning_session_time' => '',
                'evening_session_time' => '',
            ];
            if (trim($request->input('wrk_day_' . $dayKey)) != '') {
                if (trim($request->input('cli_' . $dayKey . '_mst')) != '' && trim($request->input('cli_' . $dayKey . '_med')) != '') {
                    $cliWorkDay['morning_session_time'] = trim($request->input('cli_' . $dayKey . '_mst')) . '-' . trim($request->input('cli_' . $dayKey . '_med'));
                }

                if (trim($request->input('cli_' . $dayKey . '_nst')) != '' && trim($request->input('cli_' . $dayKey . '_ned')) != '') {
                    $cliWorkDay['evening_session_time'] = trim($request->input('cli_' . $dayKey . '_nst')) . '-' . trim($request->input('cli_' . $dayKey . '_ned'));
                }
                if (trim($cliWorkDay['morning_session_time']) != '' || trim($cliWorkDay['evening_session_time']) != '') {
                    PhysicianClinicTimesModel::create($cliWorkDay);
                }
            }
        }

        $this->flashData = [
            'status' => 1,
            'message' => 'Successfully hospital has been created.',
        ];

        $request->session()->flash('flashData', $this->flashData);

        return redirect()->route('admin.hospitals.index');
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
        $pageData['days'] = $this->weekDays;
        $pageData['countries'] = CountryModel::where('id',101)->activeOnly();
        $pageData['physicians'] = User::select(['id', 'first_name', 'last_name'])->role('physician')->orderBy('first_name')->get();
        $pageData['data'] = HospitalModel::find($id);
        $pageData['states'] = StateModel::where('country_id', $pageData['data']->country)->activeOnly();
        $pageData['cities'] = DistrictModel::where('state_id', $pageData['data']->state)->activeOnly();

        return view('backend.edit_hospital', $pageData);
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
        $data = HospitalModel::find($id);
        $numbers = [];
        for($i=1;$i<=$request->rows;$i++)
        {
            if(trim($request->input('cnt_name_'.$i))!='' && trim($request->input('cnt_number_'.$i))!='')
            {
                array_push($numbers,[
                    'name' => $request->input('cnt_name_'.$i),
                    'number' => $request->input('cnt_number_'.$i)
                ]);
            }
        }

        $photo = $data->profile_image;
        if ($request->has('photo')) {
            $photo = Auth::id() . '_' . time() . '.' . $request->file('photo')->extension();
            Storage::putFileAs(
                'avatars', $request->file('photo'), $photo
            );
        }

        $desc = isset($request->wrk_times_others) ? trim($request->cli_wrk_others) : '';

        //Clinic creation
        HospitalModel::where('id',$id)->update([
            'name' => trim($request->name),
            'since' => trim($request->since),
            'address' => trim($request->cli_address),
            'district' => trim($request->cli_district),
            'state' => trim($request->cli_state),
            'country' => trim($request->cli_country),
            'pincode' => trim($request->cli_pincode),
            'email_address' => trim($request->cli_email),
            'website' => trim($request->cli_website),
            'mobile_no' => trim($request->cli_mobile_no),
            'about_us' => trim($request->cli_about_us),
            'landmark' => trim($request->cli_landmark),
            'other_description' => trim($desc),
            'profile_image' => $photo,
            'contact_numbers' => serialize($numbers),
            'is_branch' => $request->clinic_br_detail
        ]);

        //Achievements
        PhysicianMembershipModel::where('record_type',$id)->delete();
        for ($i = 1; $i <= trim($request->ach_rows); $i++) {
            if ($request->has('ach_' . $i) && !empty($request->input('ach_' . $i))) {
                PhysicianMembershipModel::create([
                    'user_id' => Auth::id(),
                    'record_type' => $id,
                    'description' => $request->input('ach_' . $i),
                ]);
            }
        }

        PhysicianClinicTimesModel::where([
            ['user_id', '=',  Auth::id()],
            ['clinic_type', '=', 'hospital'], 
            ['clinic_id', '=', $id]
        ])->delete();
        foreach ($this->weekDays as $dayKey => $day) {
            $cliWorkDay = [
                'user_id' =>  Auth::id(),
                'clinic_id' => $id,
                'clinic_type' => 'hospital',
                'day_name' => $dayKey,
                'morning_session_time' => '',
                'evening_session_time' => '',
            ];
            if (trim($request->input('wrk_day_' . $dayKey)) != '') {
                if (trim($request->input('cli_' . $dayKey . '_mst')) != '' && trim($request->input('cli_' . $dayKey . '_med')) != '') {
                    $cliWorkDay['morning_session_time'] = trim($request->input('cli_' . $dayKey . '_mst')) . '-' . trim($request->input('cli_' . $dayKey . '_med'));
                }

                if (trim($request->input('cli_' . $dayKey . '_nst')) != '' && trim($request->input('cli_' . $dayKey . '_ned')) != '') {
                    $cliWorkDay['evening_session_time'] = trim($request->input('cli_' . $dayKey . '_nst')) . '-' . trim($request->input('cli_' . $dayKey . '_ned'));
                }
                if (trim($cliWorkDay['morning_session_time']) != '' || trim($cliWorkDay['evening_session_time']) != '') {
                    PhysicianClinicTimesModel::create($cliWorkDay);
                }
            }
        }

        $this->flashData = [
            'status' => 1,
            'message' => 'Successfully hospital has been updated.',
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

    public function updateStatus(Request $request, $userId, $statusCode)
    {
        $result = HospitalModel::where('id', trim($userId))
            ->update([
                'status' => trim($statusCode),
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

    public function listGalleries(Request $request)
    {
        $clinicData = HospitalModel::find($request->clinicId);

        return response()->json([
            'clinicData' => [
                'id' => $clinicData->user_id,
                'name' => trim($clinicData->name),
                'mobile' => $clinicData->mobile_no,
                'email' => $clinicData->email_address,
            ],
            'html' => view('backend.physician.list_hospital_galleries', [
                'data' => $clinicData,
                'consultants' => $clinicData->galleries()->latest()->get(),
                'route_name' => 'hospitals'
            ])->render(),
        ]);
    }

    public function listConsultants(Request $request)
    {
        $selfConsult = HospitalConsultantModel::where([
            ['hospital_id', '=', $request->clinicId],
            // ['self_register', '=', '1'],
            ['status', '!=', '2'],
        ])->count();

        $clinicData = HospitalModel::find($request->clinicId);

        return response()->json([
            'clinicData' => [
                'id' => $clinicData->user_id,
                'name' => trim($clinicData->name),
                'mobile' => $clinicData->mobile_no,
                'email' => $clinicData->email_address,
            ],
            'html' => view('backend.physician.list_hospital_consultants', [
                'data' => $clinicData,
            ])->render(),
        ]);
    }
}
