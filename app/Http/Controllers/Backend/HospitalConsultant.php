<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Backend\HospitalConsultantModel;
use App\Models\Backend\HospConsultsWorkModel;
use App\Models\Auth\User;
use App\Models\CountryModel;
use App\Models\DistrictModel;
use App\Models\Physician\PhysicianClinicConsultsModel;
use App\Models\Physician\PhysicianClinicModel;
use App\Models\Physician\PhysicianClinicTimesModel;
use App\Models\StateModel;
use DataTables;
use Illuminate\Database\Eloquent\Builder;
use Storage;
use App\Models\HospitalModel;

class HospitalConsultant extends Controller
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
    public function index()
    {
        if ($request->ajax()) {
            $physicianId = $request->has('physician') ? trim($request->physician) : false;
            $clinics = HospitalConsultantModel::select([
                'id', 'name', 'address', 'mobile_no', 'email_address', 'district', 'state', 'country', 'pincode', 'landmark', 'website', 'status',
            ])
                ->Where(function ($query) use ($physicianId) {
                    if ($physicianId != false) {
                        $query->where('user_id', $physicianId);
                    }
                })
                ->where([
                    ['status', '!=', '2'],
                    ['clinic_type', '=', 1],
                ])->latest()->get();

            return Datatables::of($clinics)
                ->addIndexColumn()
                ->addColumn('contact', function ($row) {
                    $contact = '<i class="fa fa-envelope fa-fw"></i>' . $row->email_address;
                    $contact .= '<br><i class="fa fa-mobile fa-fw"></i>' . $row->mobile_no;
                    if (!empty($row->landline)) {
                        $contact .= '<br><i class="fa fa-phone fa-fw"></i>' . $row->landline;
                    }
                    return $contact;
                })
                ->addColumn('photo', function ($row) {
                    // if(!empty($row->physicianProfile->avatar))
                    // {
                    //     return '<a href="'.url('storage/app/avatars/'.$row->physicianProfile->avatar).'" target="new"><img class="" src="'.url('storage/app/avatars/'.$row->physicianProfile->avatar).'" width="65" height="65">';
                    // }else{
                    return '';
                    // }
                })
                ->addColumn('actions', function ($row) use ($physicianId) {
                    if ($row->status == '1') {
                        $actions = '<a href="javascript:void(0);" class="btn btn-outline-dark changeStatus" data-rowurl="' . route('admin.physician.clinics.updateStatus', [$row->id, 0]) . '" data-row="' . $row->id . '"><i class="fa fa-fw fa-lock"></i></a> ';

                    } else if ($row->status == '0') {

                        $actions = '<a href="javascript:void(0);" class="btn btn-outline-success changeStatus" data-rowurl="' . route('admin.physician.clinics.updateStatus', [$row->id, 1]) . '" data-row="' . $row->id . '"><i class="fa fa-fw fa-unlock-alt"></i></a> ';
                    }

                    $actions .= '<a href="' . route('admin.physician.clinics.edit', $row->id) . '"  class="btn btn-outline-info"><i class="fa fa-fw fa-pencil"></i></a> ';
                    // $actions .= '<a href="' . route('admin.physician.consultants.index', ['page_option' => 'clinics', 'clinic' => $row->id, 'physician' => $physicianId]) . '" title="View Consultants" class="btn btn-outline-info"><i class="fa fa-fw fa-user"></i></a>';
                    $actions .= '<a href="javascript:void(0);" id="viewConsult_btn_' . $row->id . '" data-rowId ="' . $row->id . '" title="View Consultants" class="btn btn-outline-info viewConsultant"><i class="fa fa-fw fa-users"></i></a>';
                    $actions .= ' <a title="View Gallery" href="' . route('admin.physician.gallery.index', ['clinic' => $row->id]) . '" class="btn btn-outline-dark"><i class="fa fa-fw fa-photo"></i></a>';
                    $actions .= ' <a href="javascript:void(0);" data-rowurl="' . route('admin.physician.clinics.updateStatus', [$row->id, 2]) . '" data-row="' . $row->id . '" class="btn removeRow btn-outline-danger"><i class="fa fa-fw fa-trash"></i></a>';

                    return $actions;
                })
                ->rawColumns(['contact', 'actions', 'photo'])
                ->make(true);
        }
        $pageData['days'] = $this->weekDays;

        return view('backend.physician.list_physicians_clinics', $pageData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $clinicData = HospitalModel::find($request->clinic);

        //Consultant Creation
        $consultant = HospitalConsultantModel::create([
            'self_register' => trim($request->clinic_user)!='' ? '1' : '0',
            'user_id' => $clinicData->user_id,
            'hospital_id' => $request->clinic,
            'name' => trim($request->clinic_user)!='' ? $clinicData->name  : trim($request->cli_cons_doc_name),
            'speciality' => trim($request->cli_cons_doc_spec),
            'email_address' => trim($request->cli_cons_doc_email),
            'mobile_no' => trim($request->cli_cons_doc_mobile),
            'monthly_visit' => trim($request->cli_cons_month_visit),
            'others' => trim($request->cli_cons_wrk_others),
        ]);

        //Clinic consult times
        foreach ($this->weekDays as $dayKey => $day) {
            $cliConsWorkDay = [
                'user_id' => $clinicData->user_id,
                'hospital_id' => $request->clinic,
                'consulting_id' => $consultant->id,
                'day_name' => $dayKey,
                'morning_session_time' => '',
                'evening_session_time' => '',
            ];
            if (trim($request->input('cons_day_' . $dayKey)) != '') {
                if (trim($request->input('cli_cons_' . $dayKey . '_mst')) != '' && trim($request->input('cli_cons_' . $dayKey . '_med')) != '') {
                    $cliConsWorkDay['morning_session_time'] = $request->input('cli_cons_' . $dayKey . '_mst');
                    $cliConsWorkDay['morning_session_time'] .= '-' . $request->input('cli_cons_' . $dayKey . '_med');
                }

                if (trim($request->input('cli_cons_' . $dayKey . '_nst')) != '' && trim($request->input('cli_cons_' . $dayKey . '_ned')) != '') {
                    $cliConsWorkDay['evening_session_time'] = $request->input('cli_cons_' . $dayKey . '_nst');
                    $cliConsWorkDay['evening_session_time'] .= '-' . $request->input('cli_cons_' . $dayKey . '_ned');
                }

                if (trim($cliConsWorkDay['morning_session_time']) != '' || trim($cliConsWorkDay['evening_session_time']) != '') {
                    HospConsultsWorkModel::create($cliConsWorkDay);
                }

            }
        }

        $this->flashData = [
            'status' => 1,
            'message' => 'Successfully consultant has been created.',
        ];

        // $request->session()->flash('flashData', $this->flashData);

        return response()->json([
            'status' => 1,
            'message' => 'Successfully consultant has been created.',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = HospitalConsultantModel::find($id);

        return response()->json([
            'data' => $data,
            'times' => $data->workingDays()->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
        $data = HospitalConsultantModel::find($id);

        HospitalConsultantModel::where([
            ['id', '=', $id],
        ])->update([
            'name' => trim($request->cli_cons_doc_name),
            'speciality' => trim($request->cli_cons_doc_spec),
            'mobile_no' => trim($request->cli_cons_doc_mobile),
            'monthly_visit' => trim($request->cli_cons_month_visit),
            'others' => trim($request->cli_cons_wrk_others),
        ]);

        HospConsultsWorkModel::where([
            ['consulting_id', '=', $id],
            ['status', '!=', '2'],
        ])->update([
            'status' => '2',
        ]);

        foreach ($this->weekDays as $dayKey => $day) {
            $cliConsWorkDay = [
                'user_id' => $data->user_id,
                'hospital_id' => $data->hospital_id,
                'consulting_id' => $id,
                'day_name' => $dayKey,
                'morning_session_time' => '',
                'evening_session_time' => '',
            ];
            if (trim($request->input('cons_day_' . $dayKey)) != '') {
                if (trim($request->input('cli_cons_' . $dayKey . '_mst')) != '' && trim($request->input('cli_cons_' . $dayKey . '_med')) != '') {
                    $cliConsWorkDay['morning_session_time'] = $request->input('cli_cons_' . $dayKey . '_mst');
                    $cliConsWorkDay['morning_session_time'] .= '-' . $request->input('cli_cons_' . $dayKey . '_med');
                }

                if (trim($request->input('cli_cons_' . $dayKey . '_nst')) != '' && trim($request->input('cli_cons_' . $dayKey . '_ned')) != '') {
                    $cliConsWorkDay['evening_session_time'] = $request->input('cli_cons_' . $dayKey . '_nst');
                    $cliConsWorkDay['evening_session_time'] .= '-' . $request->input('cli_cons_' . $dayKey . '_ned');
                }

                if (trim($cliConsWorkDay['morning_session_time']) != '' || trim($cliConsWorkDay['evening_session_time']) != '') {
                    HospConsultsWorkModel::create($cliConsWorkDay);
                }
            }
        }

        $this->flashData = [
            'status' => 1,
            'message' => 'Successfully consultant detail has been updated.',
        ];

        // $request->session()->flash('flashData', $this->flashData);

        return response()->json([
            'status' => 1,
            'message' => 'Successfully consultant detail has been updated.',
        ]);
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
        $result = HospitalConsultantModel::where('id', trim($userId))
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
}
