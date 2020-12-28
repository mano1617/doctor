<?php

use App\Http\Controllers\Backend\DashboardController;

// All route names are prefixed with 'admin.'.
Route::redirect('/', '/admin/dashboard', 301);
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('list/states', [DashboardController::class, 'listStates'])->name('getStates');
Route::get('list/districts', [DashboardController::class, 'listDistricts'])->name('getDistricts');

require __DIR__ . '/physician.php';

//Medical Student
Route::group(['prefix' => 'users'], function () {
    Route::resource('medical-student', 'MedicalStudentController');
    Route::post('medical-student/check-email-address','MedicalStudentController@checkAddress')->name('medical-student.checkEmail');
    Route::get('medical-student/update/status/{userId}/{statusCode}','MedicalStudentController@updateStatus')->name('medical-student.updateStatus');
});

//For Masters
Route::group(['prefix' => 'master'], function () {
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

    Route::resource('professional_qualifications', 'ProfessionQualifyController')->names([
        'index' => 'mstr.pro_qualify.index',
        'store' => 'mstr.pro_qualify.store',
        'edit' => 'mstr.pro_qualify.edit',
        'update' => 'mstr.pro_qualify.update',
    ]);
    Route::get('professional_qualifications/update/status/{userId}/{statusCode}', 'ProfessionQualifyController@updateStatus')->name('mstr.pro_qualify.updateStatus');
    Route::post('professional_qualifications/check-duplicate', 'ProfessionQualifyController@checkDuplicate')->name('mstr.pro_qualify.checkDuplicate');

    Route::resource('branch_medicines', 'BrMedicineMasterController')->names([
        'index' => 'mstr.branch_medicine.index',
        'store' => 'mstr.branch_medicine.store',
        'edit' => 'mstr.branch_medicine.edit',
        'update' => 'mstr.branch_medicine.update',
    ]);
    Route::get('branch_medicines/update/status/{userId}/{statusCode}', 'BrMedicineMasterController@updateStatus')->name('mstr.branch_medicine.updateStatus');
    Route::post('branch_medicines/check-duplicate', 'BrMedicineMasterController@checkDuplicate')->name('mstr.branch_medicine.checkDuplicate');
});
