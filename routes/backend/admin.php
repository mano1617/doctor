<?php

use App\Http\Controllers\Backend\DashboardController;

// All route names are prefixed with 'admin.'.
Route::redirect('/', '/admin/dashboard', 301);
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('list/states', [DashboardController::class, 'listStates'])->name('getStates');

require __DIR__ . '/physician.php';

//For Masters
Route::group(['prefix' => 'master'],function()
{
    Route::resource('designations', 'DesigMasterController')->names([
        'index' => 'mstr.designation.index',
        'store' => 'mstr.designation.store',
        'edit' => 'mstr.designation.edit',
        'update' => 'mstr.designation.update',
    ]);
    Route::get('designations/update/status/{userId}/{statusCode}', 'DesigMasterController@updateStatus')->name('mstr.designation.updateStatus');
    Route::post('designations/check-duplicate', 'DesigMasterController@checkDuplicate')->name('mstr.designation.checkDuplicate');

    Route::resource('memberships', 'MembershipMasterController')->names([
        'index' => 'mstr.membership.index',
        'store' => 'mstr.membership.store',
        'edit' => 'mstr.membership.edit',
        'update' => 'mstr.membership.update',
    ]);
    Route::get('memberships/update/status/{userId}/{statusCode}', 'MembershipMasterController@updateStatus')->name('mstr.membership.updateStatus');
    Route::post('memberships/check-duplicate', 'MembershipMasterController@checkDuplicate')->name('mstr.membership.checkDuplicate');

});

