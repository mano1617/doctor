<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\CourseModel;
use App\Models\Backend\DepartmentsModel;
use App\Models\Backend\InstitutionModel;
use App\Models\CountryModel;
use App\Models\DistrictModel;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use Storage;

class InstitutionsController extends Controller
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
            $clinics = InstitutionModel::select([
                'id', 'name', 'mobile_no', 'email_address', 'profile_image', 'status',
            ])->latest()->bothInActive()->get();

            return Datatables::of($clinics)
                ->addIndexColumn()
                ->addColumn('contact', function ($row) {
                    $contact = '<br><i class="fa fa-envelope fa-fw"></i>' . $row->email_address;
                    $contact .= '<br><i class="fa fa-mobile fa-fw"></i>' . $row->mobile_no;
                    return $contact;
                })
                ->addColumn('photo', function ($row) {
                    if (!empty($row->profile_image)) {
                        return '<a href="' . url('storage/app/profile_photos/' . $row->profile_image) . '" target="new"><img class="" src="' . url('storage/app/profile_photos/' . $row->profile_image) . '" width="65" height="65">';
                    } else {
                        return '';
                    }
                })
                ->addColumn('actions', function ($row) {
                    if ($row->status == '1') {
                        $actions = '<a href="javascript:void(0);" class="btn btn-outline-dark changeStatus" data-rowurl="' . route('admin.homeopathic-institution.updateStatus', [$row->id, 0]) . '" data-row="' . $row->id . '"><i class="fa fa-fw fa-lock"></i></a> ';
                    } else if ($row->status == '0') {
                        $actions = '<a href="javascript:void(0);" class="btn btn-outline-success changeStatus" data-rowurl="' . route('admin.homeopathic-institution.updateStatus', [$row->id, 1]) . '" data-row="' . $row->id . '"><i class="fa fa-fw fa-unlock-alt"></i></a> ';
                    }

                    $actions .= '<a href="' . route('admin.homeopathic-institution.edit', $row->id) . '"  class="btn btn-outline-info"><i class="fa fa-fw fa-pencil"></i></a> ';
                    $actions .= ' <a href="javascript:void(0);" data-rowurl="' . route('admin.homeopathic-institution.updateStatus', [$row->id, 2]) . '" data-row="' . $row->id . '" class="btn removeRow btn-outline-danger"><i class="fa fa-fw fa-trash"></i></a>';

                    return $actions;
                })
                ->rawColumns(['contact', 'actions', 'photo'])
                ->make(true);
        }

        return view('backend.list_homoe_institutions');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageData['ug_groups'] = DepartmentsModel::groups('UG');
        $pageData['pg_groups'] = DepartmentsModel::groups('PG');
        $pageData['countries'] = CountryModel::where('id', 101)->activeOnly();
        $pageData['states'] = CountryModel::find(101);
        $pageData['states'] = $pageData['states'] ? $pageData['states']->states : [];
        $pageData['courses'] = CourseModel::select(['id', 'name'])->activeOnly();
        $pageData['cities'] = DistrictModel::activeOnly();

        return view('backend.create_homoe_institution', $pageData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $courses = [];
        $ugCourses = [];
        $pgCourses = [];
        $ipds = [];

        $contactNos = [];
        for ($i = 1; $i <= $request->rows; $i++) {
            if (trim($request->input('cnt_name_' . $i)) != '' && trim($request->input('cnt_number_' . $i)) != '') {
                array_push($contactNos, [
                    'name' => $request->input('cnt_name_' . $i),
                    'number' => $request->input('cnt_number_' . $i),
                ]);
            }
        }

        $achieves = [];
        for ($i = 1; $i <= $request->ach_rows; $i++) {
            if (trim($request->input('ach_' . $i)) != '' && trim($request->input('ach_' . $i)) != '') {
                array_push($achieves, [
                    'data' => $request->input('ach_' . $i),
                ]);
            }
        }

        $acreds = [];
        for ($i = 1; $i <= $request->acred_rows; $i++) {
            if (trim($request->input('ared_' . $i)) != '' && trim($request->input('ared_' . $i)) != '') {
                array_push($acreds, [
                    'data' => $request->input('ared_' . $i),
                ]);
            }
        }

        $opds = [];
        for ($i = 1; $i <= $request->opd_rows; $i++) {
            if ($request->has('opd_' . $i)) {
                if (trim($request->input('opd_' . $i)) != '' && trim($request->input('sp_opd_' . $i)) != '') {
                    array_push($opds, [
                        'opd' => $request->input('opd_' . $i),
                        'units' => $request->input('no_units_' . $i),
                        'sp_opd' => $request->input('sp_opd_' . $i),
                    ]);
                }
            }
        }

        

        if ($request->has('pg_groups')) {
            foreach ($request->pg_groups as $pg) {
                array_push($pgCourses, $pg);
            }
        }

        if ($request->has('ug_groups')) {
            foreach ($request->ug_groups as $ug) {
                array_push($ugCourses, $ug);
            }
        }

        $avatarName = '';
        if ($request->has('image')) {
            $avatarName = auth()->id() . '_' . time() . '.' . $request->file('image')->extension();
            Storage::putFileAs(
                'profile_photos', $request->file('image'), $avatarName
            );
        }

        if ($request->has('courses')) {
            foreach ($request->courses as $ug) {
                if (CourseModel::where('id', $ug)->count() > 0) {
                    array_push($courses, $ug);
                } else {
                    $createCo = CourseModel::create([
                        'name' => $ug,
                    ]);
                    array_push($courses, $createCo->id);
                }
            }
        }

        $ipds = [
            'ipd' => trim($request->ipd),
            'ipd_bed' => trim($request->no_beds),
            'ipd_detail' => trim($request->ipd_details)
        ];

        $insertData = [
            'user_id' => auth()->id(),
            'name' => trim($request->name),
            'since' => trim($request->since),
            'address' => trim($request->address),
            'landmark' => trim($request->landmark),
            'country' => trim($request->country),
            'state' => trim($request->state),
            'district' => trim($request->district),
            'pincode' => trim($request->pincode),
            'mobile_no' => trim($request->mobile_no),
            'email_address' => trim($request->email_address),
            'website' => trim($request->cli_website),
            'about_us' => trim($request->about_me),
            'courses' => implode(',', $courses),
            'courses_ug' => implode(',', $ugCourses),
            'courses_pg' => implode(',', $pgCourses),
            'contact_nos' => serialize($contactNos),
            'achievements' => serialize($achieves),
            'acreditations' => serialize($acreds),
            'opd_hospital' => serialize($opds),
            'ipd_hospital' => serialize($ipds),
            'profile_image' => $avatarName,
        ];

        // //Clinic creation
        $createClinic = InstitutionModel::create($insertData);

        $this->flashData = [
            'status' => 1,
            'message' => 'Successfully institution has been created.',
        ];

        $request->session()->flash('flashData', $this->flashData);

        return redirect()->route('admin.homeopathic-institution.index');
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

        $pageData['data'] = InstitutionModel::find($id);
        $pageData['ug_groups'] = DepartmentsModel::groups('UG');
        $pageData['pg_groups'] = DepartmentsModel::groups('PG');
        $pageData['countries'] = CountryModel::where('id', 101)->activeOnly();
        $pageData['states'] = CountryModel::find(101);
        $pageData['states'] = $pageData['states'] ? $pageData['states']->states : [];
        $pageData['courses'] = CourseModel::select(['id', 'name'])->activeOnly();
        $pageData['cities'] = DistrictModel::where('state_id',$pageData['data']->state)->activeOnly();

        return view('backend.edit_homoe_institution', $pageData);
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
        $data = InstitutionModel::find($id);

        $courses = [];
        $ugCourses = [];
        $pgCourses = [];
        $ipds = [];

        $contactNos = [];
        for ($i = 1; $i <= $request->rows; $i++) {
            if (trim($request->input('cnt_name_' . $i)) != '' && trim($request->input('cnt_number_' . $i)) != '') {
                array_push($contactNos, [
                    'name' => $request->input('cnt_name_' . $i),
                    'number' => $request->input('cnt_number_' . $i),
                ]);
            }
        }

        $achieves = [];
        for ($i = 1; $i <= $request->ach_rows; $i++) {
            if (trim($request->input('ach_' . $i)) != '' && trim($request->input('ach_' . $i)) != '') {
                array_push($achieves, [
                    'data' => $request->input('ach_' . $i),
                ]);
            }
        }

        $acreds = [];
        for ($i = 1; $i <= $request->acred_rows; $i++) {
            if (trim($request->input('ared_' . $i)) != '' && trim($request->input('ared_' . $i)) != '') {
                array_push($acreds, [
                    'data' => $request->input('ared_' . $i),
                ]);
            }
        }

        $opds = [];
        for ($i = 1; $i <= $request->opd_rows; $i++) {
            if ($request->has('opd_' . $i)) {
                if (trim($request->input('opd_' . $i)) != '' && trim($request->input('sp_opd_' . $i)) != '') {
                    array_push($opds, [
                        'opd' => $request->input('opd_' . $i),
                        'units' => $request->input('no_units_' . $i),
                        'sp_opd' => $request->input('sp_opd_' . $i),
                    ]);
                }
            }
        }

        if ($request->has('pg_groups')) {
            foreach ($request->pg_groups as $pg) {
                array_push($pgCourses, $pg);
            }
        }

        if ($request->has('ug_groups')) {
            foreach ($request->ug_groups as $ug) {
                array_push($ugCourses, $ug);
            }
        }

        $avatarName = $data->profile_image;
        if ($request->has('image')) {
            $avatarName = auth()->id() . '_' . time() . '.' . $request->file('image')->extension();
            Storage::putFileAs(
                'profile_photos', $request->file('image'), $avatarName
            );
        }

        if ($request->has('courses')) {
            foreach ($request->courses as $ug) {
                if (CourseModel::where('id', $ug)->count() > 0) {
                    array_push($courses, $ug);
                } else {
                    $createCo = CourseModel::create([
                        'name' => $ug,
                    ]);
                    array_push($courses, $createCo->id);
                }
            }
        }

        $ipds = [
            'ipd' => trim($request->ipd),
            'ipd_bed' => trim($request->no_beds),
            'ipd_detail' => trim($request->ipd_details)
        ];

        $insertData = [
            'name' => trim($request->name),
            'since' => trim($request->since),
            'address' => trim($request->address),
            'landmark' => trim($request->landmark),
            'country' => trim($request->country),
            'state' => trim($request->state),
            'district' => trim($request->district),
            'pincode' => trim($request->pincode),
            'mobile_no' => trim($request->mobile_no),
            'email_address' => trim($request->email_address),
            'website' => trim($request->cli_website),
            'about_us' => trim($request->about_me),
            'courses' => implode(',', $courses),
            'courses_ug' => implode(',', $ugCourses),
            'courses_pg' => implode(',', $pgCourses),
            'contact_nos' => serialize($contactNos),
            'achievements' => serialize($achieves),
            'acreditations' => serialize($acreds),
            'opd_hospital' => serialize($opds),
            'ipd_hospital' => serialize($ipds),
            'profile_image' => $avatarName,
        ];

        $createClinic = InstitutionModel::where([
            ['user_id', '=', auth()->id()],
            ['id','=',$id]
        ])->update($insertData);

        $this->flashData = [
            'status' => 1,
            'message' => 'Successfully data has been updated.',
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
        $result = InstitutionModel::where('id', trim($userId))
            ->update([
                'status' => trim($statusCode),
            ]);

        if ($result) {
            $this->flashData = [
                'status' => 1,
                'message' => $statusCode == 2 ? 'Successfully data has been removed' : 'Successfully status has been changed',
            ];

            $request->session()->flash('flashData', $this->flashData);
        }

        return response()->json([
            'status' => 1,
        ]);
    }
}
