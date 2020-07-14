<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CountryModel;
/**
 * Class DashboardController.
 */
class DashboardController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('backend.dashboard');
    }

    public function listStates(Request $request)
    {
        return response()->json([
            'status' => 1,
            'data' => CountryModel::find(trim($request->countryId))->states
        ]);
    }
}
