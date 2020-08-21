<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Physician\PhysicianClinicConsultsModel;
use App\Models\Physician\PhysicianClinicConsultsTimesModel;
use App\Models\Physician\PhysicianClinicModel;
use DataTables;
use Illuminate\Http\Request;

class PhyConsultantsController extends Controller
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
            $clinicId = $request->has('clinic') ? trim($request->clinic) : false;

            $clinics = PhysicianClinicConsultsModel::select([
                'id', 'name', 'mobile_no', 'email_address', 'status', 'speciality',
            ])
                ->where([
                    ['clinic_id', '=', $clinicId],
                    ['status', '!=', '2'],
                ])->latest()->get();

            return Datatables::of($clinics)
                ->addIndexColumn()
                ->addColumn('contact', function ($row) {
                    $contact = '<i class="fa fa-envelope fa-fw"></i>' . $row->email_address;
                    $contact .= '<br><i class="fa fa-mobile fa-fw"></i>' . $row->mobile_no;
                    return $contact;
                })
                ->addColumn('actions', function ($row) {
                    if ($row->status == '1') {
                        $actions = '<a href="javascript:void(0);" class="btn btn-outline-dark changeStatus" data-rowurl="' . route('admin.physician.consultants.updateStatus', [$row->id, 0]) . '" data-row="' . $row->id . '"><i class="fa fa-fw fa-lock"></i></a> ';

                    } else if ($row->status == '0') {

                        $actions = '<a href="javascript:void(0);" class="btn btn-outline-success changeStatus" data-rowurl="' . route('admin.physician.consultants.updateStatus', [$row->id, 1]) . '" data-row="' . $row->id . '"><i class="fa fa-fw fa-unlock-alt"></i></a> ';
                    }

                    $actions .= '<a href="' . route('admin.physician.consultants.edit', $row->id) . '" class="btn btn-outline-info"><i class="fa fa-fw fa-pencil"></i></a> ';
                    $actions .= ' <a href="javascript:void(0);" data-rowurl="' . route('admin.physician.consultants.updateStatus', [$row->id, 2]) . '" data-row="' . $row->id . '" class="btn removeRow btn-outline-danger"><i class="fa fa-fw fa-trash"></i></a>';

                    return $actions;
                })
                ->rawColumns(['contact', 'actions', 'photo'])
                ->make(true);
        }

        return view('backend.physician.list_physicians_consultants');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageData['days'] = $this->weekDays;
        return view('backend.physician.create_physician_consultants', $pageData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $clinicData = PhysicianClinicModel::find($request->clinic);

        //Consultant Creation
        $consultant = PhysicianClinicConsultsModel::create([
            'self_register' => trim($request->clinic_user)!='' ? '1' : '0',
            'user_id' => $clinicData->user_id,
            'clinic_id' => $request->clinic,
            'name' => trim($request->clinic_user)!='' ? $clinicData->user->fullname  : trim($request->cli_cons_doc_name),
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
                'clinic_id' => $request->clinic,
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
                    PhysicianClinicConsultsTimesModel::create($cliConsWorkDay);
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
        $data = PhysicianClinicConsultsModel::find($id);

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
        $pageData['days'] = $this->weekDays;
        $pageData['data'] = PhysicianClinicConsultsModel::find($id);

        return view('backend.physician.edit_physician_consultants', $pageData);
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

        $data = PhysicianClinicConsultsModel::find($id);

        PhysicianClinicConsultsModel::where([
            ['id', '=', $id],
        ])->update([
            'name' => trim($request->cli_cons_doc_name),
            'speciality' => trim($request->cli_cons_doc_spec),
            'mobile_no' => trim($request->cli_cons_doc_mobile),
            'monthly_visit' => trim($request->cli_cons_month_visit),
            'others' => trim($request->cli_cons_wrk_others),
        ]);

        PhysicianClinicConsultsTimesModel::where([
            ['consulting_id', '=', $id],
            ['status', '!=', '2'],
        ])->update([
            'status' => '2',
        ]);

        foreach ($this->weekDays as $dayKey => $day) {
            $cliConsWorkDay = [
                'user_id' => $data->user_id,
                'clinic_id' => $data->clinic_id,
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
                    PhysicianClinicConsultsTimesModel::create($cliConsWorkDay);
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
        $result = PhysicianClinicConsultsModel::where('id', trim($userId))
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
