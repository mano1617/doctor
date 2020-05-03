<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Auth\User;
use Illuminate\Support\Facades\Hash;
use DataTables;
use DB;

class PhysicianController extends Controller
{
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
                ->bothInActive();

            return Datatables::of($users)
                ->addIndexColumn()
                ->addColumn('first_name', function($row)
                {
                    return $row->first_name.' '.$row->last_name;
                })
                ->addColumn('contact', function($row)
                {
                     $contact = '<i class="fa fa-envelope fa-fw"></i>'.$row->email;
                     $contact .= '<br><i class="fa fa-phone fa-fw"></i>'.$row->email;
                     $contact .= '<br><i class="fa fa-mobile fa-fw"></i>'.$row->email;
                     return $contact;
                })
                ->addColumn('photo', function()
                {
                    return '1';
                })
                ->addColumn('actions', function($row)
                {

                    if($row->active==1)
                    {
                        $actions = '<a class="btn btn-outline-dark"><i class="fa fa-fw fa-lock"></i></a> ';

                    }else if($row->active==2){

                        $actions = '<a class="btn btn-outline-success"><i class="fa fa-fw fa-unlock-alt"></i></a> ';
                    }

                    $actions .= '<a class="btn btn-outline-info"><i class="fa fa-fw fa-pencil"></i></a> ';
                    $actions .= '<a class="btn btn-outline-danger"><i class="fa fa-fw fa-trash"></i></a>';
                    return $actions;
                })
                ->rawColumns(['contact', 'actions'])
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
        return view('backend.physician.create_physicians');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //print_r($request->all());

        $data = [
            'first_name' => trim($request->firstname),
            'last_name' => trim($request->lastname),
            'email' => trim($request->email_address),
            'password' => Hash::make(trim($request->confirm_password))
        ];

        $user = User::create($data);

        $user->assignRole('physician');

        //edu

        //clinic

        return redirect()->route('admin.physician.index');

        //print_r($data);
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
}
