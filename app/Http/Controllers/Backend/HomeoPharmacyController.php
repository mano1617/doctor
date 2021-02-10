<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Backend\HomoeopharmacyModel;
use App\Models\Auth\User;
use App\Models\CountryModel;
use App\Models\DistrictModel;
use App\Models\Backend\WorkTimesModel;
use App\Models\StateModel;
use DataTables;
use Illuminate\Database\Eloquent\Builder;
use Storage;
use Auth;

class HomeoPharmacyController extends Controller
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
            $clinics = HomoeopharmacyModel::select([
                'id', 'name', 'have_branch', 'address', 'mobile_no', 'profile_image', 'email_address', 'district', 'state', 'country', 'pincode', 'landmark', 'website', 'status',
            ])->where('parent_id',0)->latest()->bothInActive()->get();

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
                ->addColumn('actions', function ($row) {
                    if ($row->status == '1') {
                        $actions = '<a href="javascript:void(0);" class="btn btn-outline-dark changeStatus" data-rowurl="' . route('admin.homeopathic-pharmacy.updateStatus', [$row->id, 0]) . '" data-row="' . $row->id . '"><i class="fa fa-fw fa-lock"></i></a> ';

                    } else if ($row->status == '0') {

                        $actions = '<a href="javascript:void(0);" class="btn btn-outline-success changeStatus" data-rowurl="' . route('admin.homeopathic-pharmacy.updateStatus', [$row->id, 1]) . '" data-row="' . $row->id . '"><i class="fa fa-fw fa-unlock-alt"></i></a> ';
                    }

                    $actions .= '<a href="' . route('admin.homeopathic-pharmacy.edit', $row->id) . '"  class="btn btn-outline-info"><i class="fa fa-fw fa-pencil"></i></a> ';
                    if ($row->have_branch == '1') {
                        $actions .= '<a href="' . route('admin.homeopathic-pharmacy.viewBranchs', $row->id) . '" title="View Branches" class="btn btn-outline-info"><i class="fa fa-fw fa-bank"></i></a>';
                    }
                    $actions .= ' <a title="View Gallery" href="javascript:void(0);" id="viewGallery_btn_' . $row->id . '" data-rowId ="' . $row->id . '"class="btn btn-outline-dark viewGallery"><i class="fa fa-fw fa-photo"></i></a>';
                    $actions .= ' <a href="javascript:void(0);" data-rowurl="' . route('admin.homeopathic-pharmacy.updateStatus', [$row->id, 2]) . '" data-row="' . $row->id . '" class="btn removeRow btn-outline-danger"><i class="fa fa-fw fa-trash"></i></a>';

                    return $actions;
                })
                ->rawColumns(['contact', 'actions', 'photo'])
                ->make(true);
        }
        $pageData['days'] = $this->weekDays;

        return view('backend.list_homoe_pharmacy', $pageData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageData['days'] = $this->weekDays;
        $pageData['countries'] = CountryModel::activeOnly();
        $pageData['cities'] = DistrictModel::where('state_id', 18)->activeOnly();
        $pageData['states'] = CountryModel::find(101);
        $pageData['states'] = $pageData['states'] ? $pageData['states']->states : [];

        return view('backend.create_homoe_pharmacy', $pageData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $photo = '';
        if ($request->has('photo')) {
            $photo = Auth::id() . '_' . time() . '.' . $request->file('photo')->extension();
            Storage::putFileAs(
                'avatars', $request->file('photo'), $photo
            );
        }

        $desc = isset($request->wrk_times_others) ? trim($request->cli_wrk_others) : '';

        //Clinic creation
        $createClinic = HomoeopharmacyModel::create([
            'user_id' => Auth::id(),
            'parent_id' => $request->has('parent_id') ? $request->parent_id : 0,
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
            'description' => trim($request->cli_about_us),
            'landmark' => trim($request->cli_landmark),
            'landline' => trim($request->cli_landline),
            'other_description' => trim($desc),
            'profile_image' => $photo,
            'have_branch' => $request->clinic_br_detail
        ]);

        $this->flashData = [
            'status' => 1,
            'message' => 'Successfully pharmacy has been created.',
        ];


        foreach ($this->weekDays as $dayKey => $day) {
            $cliWorkDay = [
                'user_id' =>  Auth::id(),
                'parent_type' => 'pharmacy',
                'parent_id' => $createClinic->id,
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
                    WorkTimesModel::create($cliWorkDay);
                }
            }
        }

        $request->session()->flash('flashData', $this->flashData);

        if($request->has('parent_id'))
        {
            return redirect()->route('admin.homeopathic-pharmacy.viewBranchs',$request->parent_id);
        }

        return redirect()->route('admin.homeopathic-pharmacy.index');
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
        $pageData['countries'] = CountryModel::activeOnly();
        $pageData['data'] = HomoeopharmacyModel::find($id);
        $pageData['states'] = StateModel::where('country_id', $pageData['data']->country)->activeOnly();
        $pageData['cities'] = DistrictModel::where('state_id', $pageData['data']->state)->activeOnly();

        return view('backend.edit_homoe_pharmacy', $pageData);
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
        $data = HomoeopharmacyModel::find($id);
        $photo = $data->profile_image;
        if ($request->has('photo')) {
            $photo = Auth::id() . '_' . time() . '.' . $request->file('photo')->extension();
            Storage::putFileAs(
                'avatars', $request->file('photo'), $photo
            );
        }

        $desc = isset($request->wrk_times_others) ? trim($request->cli_wrk_others) : '';

        //Clinic creation
        HomoeopharmacyModel::where('id',$id)->update([
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
            'description' => trim($request->cli_about_us),
            'landmark' => trim($request->cli_landmark),
            'landline' => trim($request->cli_landline),
            'other_description' => trim($desc),
            'profile_image' => $photo,
            'have_branch' => $request->clinic_br_detail
        ]);

        $this->flashData = [
            'status' => 1,
            'message' => 'Successfully pharmacy has been updated.',
        ];

        WorkTimesModel::where([
            ['parent_type','=','pharmacy'],
            ['parent_id','=',$id],
        ])->delete();

        foreach ($this->weekDays as $dayKey => $day) {
            $cliWorkDay = [
                'user_id' =>  Auth::id(),
                'parent_type' => 'pharmacy',
                'parent_id' => $id,
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
                    WorkTimesModel::create($cliWorkDay);
                }
            }
        }

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
        
    }

    public function updateStatus(Request $request, $userId, $statusCode)
    {
        $result = HomoeopharmacyModel::where('id', trim($userId))
            ->update([
                'status' => trim($statusCode),
            ]);

        if ($result) {
            $this->flashData = [
                'status' => 1,
                'message' => $statusCode == 2 ? 'Successfully pharmacy has been removed' : 'Successfully status has been changed',
            ];

            $request->session()->flash('flashData', $this->flashData);
        }

        return response()->json([
            'status' => 1,
        ]);
    }

    public function listGalleries(Request $request)
    {
        $clinicData = HomoeopharmacyModel::find($request->clinicId);

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
                'route_name' => 'homeopathic-pharmacy'
            ])->render(),
        ]);
    }

    public function viewBranchs(Request $request, $parentId)
    {
        if ($request->ajax()) {
            $clinics = HomoeopharmacyModel::select([
                'id', 'name', 'have_branch', 'address', 'mobile_no', 'profile_image', 'email_address', 'district', 'state', 'country', 'pincode', 'landmark', 'website', 'status',
            ])->where('parent_id',$parentId)->latest()->bothInActive()->get();

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
                ->addColumn('actions', function ($row) {
                    if ($row->status == '1') {
                        $actions = '<a href="javascript:void(0);" class="btn btn-outline-dark changeStatus" data-rowurl="' . route('admin.homeopathic-pharmacy.updateStatus', [$row->id, 0]) . '" data-row="' . $row->id . '"><i class="fa fa-fw fa-lock"></i></a> ';

                    } else if ($row->status == '0') {

                        $actions = '<a href="javascript:void(0);" class="btn btn-outline-success changeStatus" data-rowurl="' . route('admin.homeopathic-pharmacy.updateStatus', [$row->id, 1]) . '" data-row="' . $row->id . '"><i class="fa fa-fw fa-unlock-alt"></i></a> ';
                    }

                    $actions .= '<a href="' . route('admin.homeopathic-pharmacy.edit', $row->id) . '"  class="btn btn-outline-info"><i class="fa fa-fw fa-pencil"></i></a> ';
                    
                    $actions .= ' <a title="View Gallery" href="javascript:void(0);" id="viewGallery_btn_' . $row->id . '" data-rowId ="' . $row->id . '"class="btn btn-outline-dark viewGallery"><i class="fa fa-fw fa-photo"></i></a>';
                    $actions .= ' <a href="javascript:void(0);" data-rowurl="' . route('admin.homeopathic-pharmacy.updateStatus', [$row->id, 2]) . '" data-row="' . $row->id . '" class="btn removeRow btn-outline-danger"><i class="fa fa-fw fa-trash"></i></a>';

                    return $actions;
                })
                ->rawColumns(['contact', 'actions', 'photo'])
                ->make(true);
        }
        $pageData['days'] = $this->weekDays;

        return view('backend.list_homoe_pharmacy_branches', $pageData);
    }
}
