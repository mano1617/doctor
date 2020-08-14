<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Models\CountryModel;
use App\Models\Physician\PhysicianClinicModel;
use App\Models\Physician\PhysicianClinicTimesModel;
use App\Models\StateModel;
use DataTables;
use Illuminate\Http\Request;
use Storage;

class PhyBranchesController extends Controller
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
        $data = User::find($request->physician);
        if ($data->physicianProfile->has_branches == 0) {
            $this->flashData = [
                'status' => 0,
                'message' => "Physician don't have permission to access branches",
            ];

            $request->session()->flash('flashData', $this->flashData);
            return redirect()->route('admin.physician.index');
        }

        if ($request->ajax()) {
            $physicianId = $request->physician;
            $clinics = PhysicianClinicModel::select([
                'id', 'name', 'address', 'mobile_no', 'email_address', 'landline', 'district', 'state', 'country', 'pincode', 'landmark', 'website', 'status',
            ])
                ->where([
                    ['user_id', '=', $request->physician],
                    ['status', '!=', '2'],
                    ['clinic_type', '=', 2],
                ])->latest()->get();

            return Datatables::of($clinics)
                ->addIndexColumn()
                ->addColumn('contact', function ($row) {
                    $contact = '<i class="fa fa-envelope fa-fw"></i>' . $row->email_address;
                    $contact .= '<br><i class="fa fa-mobile fa-fw"></i>' . $row->mobile_no;
                    if (trim($row->landline) != '') {
                        $contact .= '<br><i class="fa fa-phone fa-fw"></i>' . $row->landline;
                    }
                    return $contact;
                })
                ->addColumn('actions', function ($row) use ($physicianId) {
                    if ($row->status == '1') {
                        $actions = '<a href="javascript:void(0);" class="btn btn-outline-dark changeStatus" data-rowurl="' . route('admin.physician.clinics.updateStatus', [$row->id, 0]) . '" data-row="' . $row->id . '"><i class="fa fa-fw fa-lock"></i></a> ';

                    } else if ($row->status == '0') {

                        $actions = '<a href="javascript:void(0);" class="btn btn-outline-success changeStatus" data-rowurl="' . route('admin.physician.clinics.updateStatus', [$row->id, 1]) . '" data-row="' . $row->id . '"><i class="fa fa-fw fa-unlock-alt"></i></a> ';
                    }

                    $actions .= '<a href="' . route('admin.physician.branches.edit', [$row->id, 'physician' => $physicianId]) . '" class="btn btn-outline-info"><i class="fa fa-fw fa-pencil"></i></a> ';
                    // $actions .= '<a href="' . route('admin.physician.consultants.index', ['page_option' => 'branches', 'clinic' => $row->id, 'physician' => $physicianId]) . '" title="View Consultants" class="btn btn-outline-info"><i class="fa fa-fw fa-users"></i></a>';
                    $actions .= '<a href="javascript:void(0);" id="viewConsult_btn_' . $row->id . '" data-rowId ="' . $row->id . '" title="View Consultants" class="btn btn-outline-info viewConsultant"><i class="fa fa-fw fa-users"></i></a>';
                    $actions .= ' <a title="View Gallery" href="" class="btn btn-outline-dark"><i class="fa fa-fw fa-photo"></i></a>';
                    $actions .= ' <a href="javascript:void(0);" data-rowurl="' . route('admin.physician.clinics.updateStatus', [$row->id, 2]) . '" data-row="' . $row->id . '" class="btn removeRow btn-outline-danger"><i class="fa fa-fw fa-trash"></i></a>';

                    return $actions;
                })
                ->rawColumns(['contact', 'actions', 'photo'])
                ->make(true);
        }

        $pageData['days'] = $this->weekDays;

        return view('backend.physician.list_physicians_branches', $pageData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = User::find($request->physician);
        if ($data->physicianProfile->has_branches == 0) {
            $this->flashData = [
                'status' => 0,
                'message' => "Physician don't have permission to access branches",
            ];

            $request->session()->flash('flashData', $this->flashData);
            return redirect()->route('admin.physician.index');
        }

        $pageData['days'] = $this->weekDays;
        $pageData['countries'] = CountryModel::activeOnly();
        return view('backend.physician.create_physician_branches', $pageData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = User::find($request->user);
        if ($data->physicianProfile->has_branches == 0) {
            $this->flashData = [
                'status' => 0,
                'message' => "Physician don't have permission to access branches",
            ];

            $request->session()->flash('flashData', $this->flashData);
            return redirect()->route('admin.physician.index');
        }

        $desc = trim($request->wrk_times_others) == 1 ? trim($request->cli_wrk_others) : '';

        //Clinic creation
        $createClinic = PhysicianClinicModel::create([
            'clinic_type' => 2,
            'user_id' => $request->user,
            'name' => trim($request->cli_name),
            'address' => trim($request->cli_address),
            'district' => trim($request->cli_district),
            'state' => trim($request->cli_state),
            'country' => trim($request->cli_country),
            'pincode' => trim($request->cli_pincode),
            'email_address' => trim($request->cli_email),
            'website' => trim($request->cli_website),
            'mobile_no' => trim($request->cli_mobile_no),
            'landline' => trim($request->cli_landno),
            'landmark' => trim($request->cli_landmark),
            'other_description' => trim($desc),
        ]);

        //Clinic times
        foreach ($this->weekDays as $dayKey => $day) {
            $cliWorkDay = [
                'user_id' => $request->user,
                'clinic_id' => $createClinic->id,
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
            'message' => 'Successfully branch has been created',
        ];

        $request->session()->flash('flashData', $this->flashData);

        return redirect()->route('admin.physician.branches.index', ['physician' => $request->user]);
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
    public function edit(Request $request, $id)
    {
        $data = User::find($request->physician);
        if ($data->physicianProfile->has_branches == 0) {
            $this->flashData = [
                'status' => 0,
                'message' => "Physician don't have permission to access branches",
            ];

            $request->session()->flash('flashData', $this->flashData);
            return redirect()->route('admin.physician.index');
        }

        $pageData['days'] = $this->weekDays;
        $pageData['countries'] = CountryModel::activeOnly();
        $pageData['physicians'] = User::select(['id', 'first_name', 'last_name'])->role('physician')->orderBy('first_name')->get();
        $pageData['data'] = PhysicianClinicModel::find($id);
        $pageData['states'] = StateModel::where('country_id', $pageData['data']->country)->activeOnly();
        return view('backend.physician.edit_physician_branches', $pageData);
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
        $recordInfo = PhysicianClinicModel::find($id);

        $data = User::find($recordInfo->user_id);
        if ($data->physicianProfile->has_branches == 0) {
            $this->flashData = [
                'status' => 0,
                'message' => "Physician don't have permission to access branches",
            ];

            $request->session()->flash('flashData', $this->flashData);
            return redirect()->route('admin.physician.index');
        }

        $desc = trim($request->wrk_times_others) == 1 ? trim($request->cli_wrk_others) : '';

        PhysicianClinicModel::where('id', $id)->update([
            'name' => trim($request->cli_name),
            'address' => trim($request->cli_address),
            'district' => trim($request->cli_district),
            'state' => trim($request->cli_state),
            'country' => trim($request->cli_country),
            'pincode' => trim($request->cli_pincode),
            'email_address' => trim($request->cli_email),
            'website' => trim($request->cli_website),
            'mobile_no' => trim($request->cli_mobile_no),
            'landline' => trim($request->cli_landno),
            'landmark' => trim($request->cli_landmark),
            'other_description' => trim($desc),
        ]);

        //Delete prev records
        PhysicianClinicTimesModel::where([
            ['user_id', '=', $recordInfo->user_id],
            ['clinic_id', '=', $id],
            ['status', '!=', '2'],
        ])->update([
            'status' => '2',
        ]);

        //Clinic times
        foreach ($this->weekDays as $dayKey => $day) {
            $cliWorkDay = [
                'user_id' => $recordInfo->user_id,
                'clinic_id' => $id,
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
            'message' => 'Successfully clinic detail has been updated.',
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
}
