<?php

Route::group(['prefix' => 'physicians'],function()
{

    Route::resource('/', 'PhysicianController')->names([
        'index' => 'physician.index',
        'create' => 'physician.create',
        'store' => 'physician.store',
        'update' => 'physician.update',
        'destroy' => 'physician.destroy'
    ]);
    Route::post('check-email-address','PhysicianController@checkAddress')->name('physician.checkEmail');
    Route::get('update/status/{userId}/{statusCode}','PhysicianController@updateStatus')->name('physician.updateStatus');

    Route::resource('clinics', 'PhyClinicsController')->names([
        'index' => 'physician.clinics.index',
        'create' => 'physician.clinics.create',
        'store' => 'physician.clinics.store',
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

    Route::resource('consultants', 'PhysicianController')->names([
        'index' => 'physician.consultants.index',
        'create' => 'physician.consultants.create',
        'store' => 'physician.consultants.store',
        'update' => 'physician.consultants.update',
    ]);
    Route::get('consultants/update/status/{userId}/{statusCode}','PhysicianController@updateStatus')->name('physician.consultants.updateStatus');
});

?>