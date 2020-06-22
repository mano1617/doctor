<?php

Route::group(['prefix' => 'users'],function()
{

    Route::resource('physicians', 'PhysicianController')->names([
        'index' => 'physician.index',
        'create' => 'physician.create',
        'store' => 'physician.store',
        'edit' => 'physician.edit',
        'update' => 'physician.update',
    ]);
    Route::post('check-email-address','PhysicianController@checkAddress')->name('physician.checkEmail');
    Route::get('update/status/{userId}/{statusCode}','PhysicianController@updateStatus')->name('physician.updateStatus');

    Route::resource('clinics', 'PhyClinicsController')->names([
        'index' => 'physician.clinics.index',
        'create' => 'physician.clinics.create',
        'store' => 'physician.clinics.store',
        'edit' => 'physician.clinics.edit',
        'update' => 'physician.clinics.update',
    ]);
    Route::get('clinics/update/status/{userId}/{statusCode}','PhyClinicsController@updateStatus')->name('physician.clinics.updateStatus');
    
    Route::resource('branches', 'PhyBranchesController')->names([
        'index' => 'physician.branches.index',
        'create' => 'physician.branches.create',
        'store' => 'physician.branches.store',
        'update' => 'physician.branches.update',
    ]);
    Route::get('branches/update/status/{userId}/{statusCode}','PhyBranchesController@updateStatus')->name('physician.branches.updateStatus');

    Route::resource('consultants', 'PhyConsultantsController')->names([
        'index' => 'physician.consultants.index',
        'create' => 'physician.consultants.create',
        'store' => 'physician.consultants.store',
        'update' => 'physician.consultants.update',
    ]);
    Route::get('consultants/update/status/{userId}/{statusCode}','PhyConsultantsController@updateStatus')->name('physician.consultants.updateStatus');
});

?>