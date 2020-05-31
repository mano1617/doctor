<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DataTables;
use DB;
use Storage;
use \Carbon\Carbon;
use App\Models\Physician\PhysicianClinicModel;
use App\Models\Physician\PhysicianClinicTimesModel;
use App\Models\Physician\PhysicianClinicConsultsModel;
use App\Models\Physician\PhysicianClinicConsultsTimesModel;

class PhyBranchesController extends Controller
{
    protected $flashData = [
        'status' => 0,
        'message' => 'Something went wrong.Try again later.'
    ];

    protected $weekDays = [
            'monday' => 'Monday',
            'tuesday' => 'Tuesday',
            'wednesday' => 'Wednesday',
            'thursday' => 'Thursday',
            'friday' => 'Friday',
            'saturday' => 'Saturday',
            'sunday' => 'Sunday'
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
            $clinics = PhysicianClinicModel::select([
                'id', 'name', 'address', 'mobile_no', 'email_address', 'landline','district', 'state', 'country', 'pincode', 'landmark', 'website', 'status'
                ])
                ->where([
                    ['user_id', '=', $request->physician],
                    ['status', '!=', '2'],
                    ['clinic_type', '=', 2]
                ])->latest()->get();

            return Datatables::of($clinics)
                ->addIndexColumn()
                ->addColumn('contact', function($row)
                {
                     $contact = '<i class="fa fa-envelope fa-fw"></i>'.$row->email_address;
                     if(trim($row->landline)!='')
                     {
                        $contact .= '<br><i class="fa fa-phone fa-fw"></i>'.$row->landline;
                     }
                     $contact .= '<br><i class="fa fa-mobile fa-fw"></i>'.$row->mobile_no;
                     return $contact;
                })
                ->addColumn('photo', function($row)
                {
                    // if(!empty($row->physicianProfile->avatar))
                    // {
                    //     return '<a href="'.url('storage/app/avatars/'.$row->physicianProfile->avatar).'" target="new"><img class="" src="'.url('storage/app/avatars/'.$row->physicianProfile->avatar).'" width="65" height="65">';
                    // }else{
                        return '';
                    // }
                })
                ->addColumn('actions', function($row)
                {
                    if($row->status=='1')
                    {
                        $actions = '<a href="javascript:void(0);" class="btn btn-outline-dark changeStatus" data-rowurl="'.route('admin.physician.clinics.updateStatus',[$row->id,0]).'" data-row="'.$row->id.'"><i class="fa fa-fw fa-lock"></i></a> ';

                    }else if($row->status=='0'){

                        $actions = '<a href="javascript:void(0);" class="btn btn-outline-success changeStatus" data-rowurl="'.route('admin.physician.clinics.updateStatus',[$row->id,1]).'" data-row="'.$row->id.'"><i class="fa fa-fw fa-unlock-alt"></i></a> ';
                    }

                    $actions .= '<a class="btn btn-outline-info"><i class="fa fa-fw fa-pencil"></i></a> ';
                    $actions .= '<a href="" title="View Consultants" class="btn btn-outline-info"><i class="fa fa-fw fa-users"></i></a>';
                    $actions .= ' <a title="View Gallery" href="" class="btn btn-outline-dark"><i class="fa fa-fw fa-photo"></i></a>';
                    $actions .= ' <a href="javascript:void(0);" data-rowurl="'.route('admin.physician.clinics.updateStatus',[$row->id,2]).'" data-row="'.$row->id.'" class="btn removeRow btn-outline-danger"><i class="fa fa-fw fa-trash"></i></a>';
                    
                    return $actions;
                })
                ->rawColumns(['contact', 'actions', 'photo'])
                ->make(true);
        }


        return view('backend.physician.list_physicians_branches');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageData['days'] = $this->weekDays;
        return view('backend.physician.create_physician_branches',$pageData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

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
            'landmark' => trim($request->cli_landmark)
        ]);
    
        //Clinic times
        foreach($this->weekDays as $dayKey => $day)
        {
            $cliWorkDay = [
                'user_id' => $request->user,
                'clinic_id' => $createClinic->id,
                'day_name' => $dayKey,
                'morning_session_time' => '',
                'evening_session_time' => '',
                'description' => trim($request->cli_wrk_others)!='' ? trim($request->cli_wrk_others) : ''
            ];
            if(trim($request->input('wrk_day_'.$dayKey))!='')
            {
                if(trim($request->input('cli_'.$dayKey.'_mst'))!='' && trim($request->input('cli_'.$dayKey.'_med'))!='')
                {
                    $cliWorkDay['morning_session_time'] = trim($request->input('cli_'.$dayKey.'_mst')).'-'.trim($request->input('cli_'.$dayKey.'_med'));
                }

                if(trim($request->input('cli_'.$dayKey.'_nst'))!='' && trim($request->input('cli_'.$dayKey.'_ned'))!='')
                {
                    $cliWorkDay['evening_session_time'] = trim($request->input('cli_'.$dayKey.'_nst')).'-'.trim($request->input('cli_'.$dayKey.'_ned'));
                }

                if(trim($cliWorkDay['morning_session_time'])!='' || trim($cliWorkDay['evening_session_time'])!='')
                {
                    PhysicianClinicTimesModel::create($cliWorkDay);
                }
            }
        }

        //Consultant Creation
        $consultant = PhysicianClinicConsultsModel::create([
                'user_id' => $request->user,
                'clinic_id' => $createClinic->id,
                'name' => trim($request->cli_cons_doc_name),
                'speciality' => trim($request->cli_cons_doc_spec),
                'email_address' => trim($request->cli_cons_doc_email),
                'mobile_no' => trim($request->cli_cons_doc_mobile),
                'monthly_visit' => trim($request->cli_cons_month_visit),
                'others' => trim($request->cli_cons_wrk_others),
                'description' => trim($request->cli_cons_aboutus)
            ]);

        //Clinic consult times
        foreach($this->weekDays as $dayKey => $day)
        {
            $cliConsWorkDay = [
                'user_id' => $request->user,
                'clinic_id' => $createClinic->id,
                'consulting_id' => $consultant->id,
                'day_name' => $dayKey,
                'morning_session_time' => '',
                'evening_session_time' => ''
            ];
            if(trim($request->input('cons_day_'.$dayKey))!='')
            {
                if(trim($request->input('cli_cons_'.$dayKey.'_mst'))!='' && trim($request->input('cli_cons_'.$dayKey.'_med'))!='')
                {
                    $cliConsWorkDay['morning_session_time'] = date('H:i:s',strtotime(trim($request->input('cli_cons_'.$dayKey.'_mst').' '.$request->input('cli_cons_'.$dayKey.'_mst_ap'))));
                    $cliConsWorkDay['morning_session_time'].= '-'.date('H:i:s',strtotime(trim($request->input('cli_cons_'.$dayKey.'_med').' '.$request->input('cli_cons_'.$dayKey.'_med_ap'))));
                }

                if(trim($request->input('cli_cons_'.$dayKey.'_nst'))!='' && trim($request->input('cli_cons_'.$dayKey.'_ned'))!='')
                {
                    $cliConsWorkDay['evening_session_time'] = date('H:i:s',strtotime(trim($request->input('cli_cons_'.$dayKey.'_nst').' '.$request->input('cli_cons_'.$dayKey.'_nst_ap'))));
                    $cliConsWorkDay['evening_session_time'].= '-'.date('H:i:s',strtotime(trim($request->input('cli_cons_'.$dayKey.'_ned').' '.$request->input('cli_cons_'.$dayKey.'_ned_ap'))));
                }

                if(trim($cliConsWorkDay['morning_session_time'])!='' || trim($cliConsWorkDay['evening_session_time'])!='')
                {
                    PhysicianClinicConsultsTimesModel::create($cliConsWorkDay);
                }
            }
        }

         $this->flashData = [
            'status' => 1,
            'message' => 'Successfully user has been registered'
        ];

        $request->session()->flash('flashData', $this->flashData);

        return redirect()->route('admin.physician.branches.index',['physician' => $request->user]);
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
        //
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
        //
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
