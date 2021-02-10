<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Backend\HomoAssociateModel;
use App\Models\Auth\User;
use DataTables;
use Illuminate\Database\Eloquent\Builder;
use Storage;
use Auth;

class HomoAssociateController extends Controller
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
            $clinics = HomoAssociateModel::select([
                'id', 'name', 'mobile_no', 'email_address', 'website', 'status',
            ])->latest()->bothInActive()->get();

            return Datatables::of($clinics)
                ->addIndexColumn()
                ->addColumn('contact', function ($row) {
                    $contact  = '<i class="fa fa-envelope fa-fw"></i>' . $row->email_address;
                    $contact .= '<br><i class="fa fa-mobile fa-fw"></i>' . $row->mobile_no;
                    // if (!empty($row->landline)) {
                    //     $contact .= '<br><i class="fa fa-phone fa-fw"></i>' . $row->landline;
                    // }
                    return $contact;
                })
                ->addColumn('photo', function ($row) {
                    return '';
                })
                ->addColumn('actions', function ($row) {
                    if ($row->status == '1') {
                        $actions = '<a href="javascript:void(0);" class="btn btn-outline-dark changeStatus" data-rowurl="' . route('admin.homeopathic-associate.updateStatus', [$row->id, 0]) . '" data-row="' . $row->id . '"><i class="fa fa-fw fa-lock"></i></a> ';
                    } else if ($row->status == '0') {
                        $actions = '<a href="javascript:void(0);" class="btn btn-outline-success changeStatus" data-rowurl="' . route('admin.homeopathic-associate.updateStatus', [$row->id, 1]) . '" data-row="' . $row->id . '"><i class="fa fa-fw fa-unlock-alt"></i></a> ';
                    }

                    $actions .= '<a href="' . route('admin.homeopathic-associate.edit', $row->id) . '"  class="btn btn-outline-info"><i class="fa fa-fw fa-pencil"></i></a> ';
                    $actions .= ' <a href="javascript:void(0);" data-rowurl="' . route('admin.homeopathic-associate.updateStatus', [$row->id, 2]) . '" data-row="' . $row->id . '" class="btn removeRow btn-outline-danger"><i class="fa fa-fw fa-trash"></i></a>';

                    return $actions;
                })
                ->rawColumns(['contact', 'actions', 'photo'])
                ->make(true);
        }

        return view('backend.list_homoe_associate');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.create_homoe_associate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $bearers = [];
        for($i=1;$i<=$request->rows;$i++)
        {
            if(trim($request->input('cnt_name_'.$i))!='' && trim($request->input('cnt_number_'.$i))!='')
            {
                array_push($bearers,[
                    'designation' => $request->input('cnt_dsg_'.$i),
                    'name' => $request->input('cnt_name_'.$i),
                    'number' => $request->input('cnt_number_'.$i)
                ]);
            }
        }

        $members = [];
        for($i=1;$i<=$request->mem_rows;$i++)
        {
            if(trim($request->input('mem_name_'.$i))!='' && trim($request->input('mem_number_'.$i))!='')
            {
                array_push($members,[
                    'place' => $request->input('mem_plc_'.$i),
                    'name' => $request->input('mem_name_'.$i),
                    'number' => $request->input('mem_number_'.$i)
                ]);
            }
        }

        //Clinic creation
        $createClinic = HomoAssociateModel::create([
            'user_id' => Auth::id(),
            'name' => trim($request->name),
            'since' => trim($request->since),
            'region_circle' => trim($request->region),
            'moto' => trim($request->moto),
            'admin_name' => trim($request->admin_name),
            'email_address' => trim($request->cli_email),
            'website' => trim($request->cli_website),
            'mobile_no' => trim($request->cli_mobile_no),
            'description' => trim($request->about_us),
            'latest_news' => trim($request->lat_nws),
            'new_events' => trim($request->new_evnts),
            'posts' => trim($request->posts),
            'notifications' => $request->notifications,
            'bearers' => serialize($bearers),
            'members' => serialize($members),
        ]);

        $this->flashData = [
            'status' => 1,
            'message' => 'Successfully associate has been created.',
        ];

        $request->session()->flash('flashData', $this->flashData);

        return redirect()->route('admin.homeopathic-associate.index');
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
        $pageData['data'] = HomoAssociateModel::find($id);

        return view('backend.edit_homoe_associate', $pageData);
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
        $bearers = [];
        for($i=1;$i<=$request->rows;$i++)
        {
            if(trim($request->input('cnt_name_'.$i))!='' && trim($request->input('cnt_number_'.$i))!='')
            {
                array_push($bearers,[
                    'designation' => $request->input('cnt_dsg_'.$i),
                    'name' => $request->input('cnt_name_'.$i),
                    'number' => $request->input('cnt_number_'.$i)
                ]);
            }
        }

        $members = [];
        for($i=1;$i<=$request->mem_rows;$i++)
        {
            if(trim($request->input('mem_name_'.$i))!='' && trim($request->input('mem_number_'.$i))!='')
            {
                array_push($members,[
                    'place' => $request->input('mem_plc_'.$i),
                    'name' => $request->input('mem_name_'.$i),
                    'number' => $request->input('mem_number_'.$i)
                ]);
            }
        }

        // print_r($request->all());
        // print_r($bearers);
        // print_r($members);
        // die();

        //Clinic creation
        HomoAssociateModel::where('id',$id)->update([
            'name' => trim($request->name),
            'since' => trim($request->since),
            'region_circle' => trim($request->region),
            'moto' => trim($request->moto),
            'admin_name' => trim($request->admin_name),
            'email_address' => trim($request->cli_email),
            'website' => trim($request->cli_website),
            'mobile_no' => trim($request->cli_mobile_no),
            'description' => trim($request->about_us),
            'latest_news' => trim($request->lat_nws),
            'new_events' => trim($request->new_evnts),
            'posts' => trim($request->posts),
            'notifications' => $request->notifications,
            'bearers' => serialize($bearers),
            'members' => serialize($members),
        ]);

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
        $result = HomoAssociateModel::where('id', trim($userId))
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
