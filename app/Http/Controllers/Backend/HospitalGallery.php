<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Backend\HospitalGalleryModel;
use Storage;
use Auth;

class HospitalGallery extends Controller
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
    public function index()
    {
        //
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
        $file = '';
        if ($request->has('fileinput')) {
            $file = Auth::id() . '_' . time() . '.' . $request->file('fileinput')->extension();
            Storage::putFileAs(
                'hospital_gallery', $request->file('fileinput'), $file
            );
        }

        //Clinic creation
        HospitalGalleryModel::create([
            'user_id' => Auth::id(),
            'title' => trim($request->title),
            'file_path' => $file,
            'file_type' => trim($request->gall_type),
            'uploaded_at' => \Carbon\Carbon::parse($request->dateinput)->format('Y-m-d'),
            'description' => trim($request->cli_cons_month_visit)!='' ? trim($request->cli_cons_month_visit) : '',
            'sorting' => trim($request->sorting)!='' ? trim($request->sorting) : 0,
            'hospital_id' => trim($request->clinic_id),
        ]);

        $this->flashData = [
            'status' => 1,
            'message' => 'Successfully data has been added.',
        ];

        return response()->json($this->flashData);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = HospitalGalleryModel::find($id);
        $data->uploaded_at = \Carbon\Carbon::parse($data->uploaded_at)->format('d-m-Y');
        return response()->json([
            'data' => $data
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
        $data = HospitalGalleryModel::find($id);
        $file = $data->file_path;
        if ($request->has('fileinput')) {
            $file = Auth::id() . '_' . time() . '.' . $request->file('fileinput')->extension();
            Storage::putFileAs(
                'hospital_gallery', $request->file('fileinput'), $file
            );
        }

        //Clinic creation
        HospitalGalleryModel::where('id',$id)->update([
            'title' => trim($request->title),
            'file_path' => $file,
            'file_type' => trim($request->gall_type),
            'uploaded_at' => \Carbon\Carbon::parse($request->dateinput)->format('Y-m-d'),
            'description' => trim($request->cli_cons_month_visit)!='' ? trim($request->cli_cons_month_visit) : '',
            'sorting' => trim($request->sorting)!='' ? trim($request->sorting) : 0,
        ]);

        $this->flashData = [
            'status' => 1,
            'message' => 'Successfully data has been updated.',
        ];

        return response()->json($this->flashData);
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
        $result = HospitalGalleryModel::where('id', trim($userId))
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
