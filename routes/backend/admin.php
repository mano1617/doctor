<?php

use App\Http\Controllers\Backend\DashboardController;

// All route names are prefixed with 'admin.'.
Route::redirect('/', '/admin/dashboard', 301);
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('list/states', [DashboardController::class, 'listStates'])->name('getStates');
Route::get('list/districts', [DashboardController::class, 'listDistricts'])->name('getDistricts');

require __DIR__ . '/physician.php';

//Homoepathic Pharmacy
Route::resource('homeopathic-pharmacy', 'HomeoPharmacyController');
Route::get('homeopathic-pharmacy/update/status/{userId}/{statusCode}', 'HomeoPharmacyController@updateStatus')->name('homeopathic-pharmacy.updateStatus');
Route::post('homeopathic-pharmacy/list-galleries', 'HomeoPharmacyController@listGalleries')->name('homeopathic-pharmacy.listGalleries');
Route::resource('homeopathic-pharmacy/galleries', 'PharmacyGalleryController')->names([
    'index' => 'homeopathic-pharmacy.galleries.index',
    'create' => 'homeopathic-pharmacy.galleries.create',
    'store' => 'homeopathic-pharmacy.galleries.store',
    'edit' => 'homeopathic-pharmacy.galleries.edit',
    'update' => 'homeopathic-pharmacy.galleries.update',
]);
Route::get('homeopathic-pharmacy/galleries/update/status/{userId}/{statusCode}', 'PharmacyGalleryController@updateStatus')->name('homeopathic-pharmacy.galleries.updateStatus');
Route::get('homeopathic-pharmacy/branches/{parentId}', 'HomeoPharmacyController@viewBranchs')->name('homeopathic-pharmacy.viewBranchs');

//Diagnostic Center
Route::resource('diagnostic-center', 'DiagnosCenterController');
Route::get('diagnostic-center/update/status/{userId}/{statusCode}', 'DiagnosCenterController@updateStatus')->name('diagnostic-center.updateStatus');
Route::post('diagnostic-center/list-galleries', 'DiagnosCenterController@listGalleries')->name('diagnostic-center.listGalleries');
Route::resource('diagnostic-center/galleries', 'DiagnosGalleryController')->names([
    'index' => 'diagnostic-center.galleries.index',
    'create' => 'diagnostic-center.galleries.create',
    'store' => 'diagnostic-center.galleries.store',
    'edit' => 'diagnostic-center.galleries.edit',
    'update' => 'diagnostic-center.galleries.update',
]);
Route::get('diagnostic-center/galleries/update/status/{userId}/{statusCode}', 'DiagnosGalleryController@updateStatus')->name('diagnostic-center.galleries.updateStatus');
Route::post('diagnostic-center/list-branches', 'DiagnosCenterController@listConsultants')->name('diagnostic-center.listConsultants');

//Homoeo Asscociate
Route::resource('homeopathic-associate', 'HomoAssociateController');
Route::get('homeopathic-associate/update/status/{userId}/{statusCode}', 'HomoAssociateController@updateStatus')->name('homeopathic-associate.updateStatus');

//Institution
Route::resource('homeopathic-institution', 'InstitutionsController');
Route::get('homeopathic-institution/update/status/{userId}/{statusCode}', 'InstitutionsController@updateStatus')->name('homeopathic-institution.updateStatus');


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

    Route::resource('courses', 'CourseMasterController')->names([
        'index' => 'mstr.course.index',
        'store' => 'mstr.course.store',
        'edit' => 'mstr.course.edit',
        'update' => 'mstr.course.update',
    ]);
    Route::get('courses/update/status/{userId}/{statusCode}', 'CourseMasterController@updateStatus')->name('mstr.course.updateStatus');
    Route::post('courses/check-duplicate', 'CourseMasterController@checkDuplicate')->name('mstr.course.checkDuplicate');

    Route::resource('departments', 'DepartmentMasterController')->names([
        'index' => 'mstr.department.index',
        'store' => 'mstr.department.store',
        'edit' => 'mstr.department.edit',
        'update' => 'mstr.department.update',
    ]);
    Route::get('departments/update/status/{userId}/{statusCode}', 'DepartmentMasterController@updateStatus')->name('mstr.department.updateStatus');
    Route::post('departments/check-duplicate', 'DepartmentMasterController@checkDuplicate')->name('mstr.department.checkDuplicate');

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
