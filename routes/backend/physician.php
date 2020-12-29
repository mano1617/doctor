<?php

Route::group(['prefix' => 'hospitals'],function()
{
    Route::resource('/', 'HospitalController')->names([
        'index' => 'hospitals.index',
        'create' => 'hospitals.create',
        'store' => 'hospitals.store',
        'edit' => 'hospitals.edit',
        'update' => 'hospitals.update',
    ]);
    Route::post('check-email-address','HospitalController@checkAddress')->name('hospitals.checkEmail');
    Route::get('update/status/{userId}/{statusCode}','HospitalController@updateStatus')->name('hospitals.updateStatus'); 
    Route::post('list-consultants', 'HospitalController@listConsultants')->name('hospitals.listConsultants');

    Route::resource('consultants', 'HospitalConsultant')->names([
        'index' => 'hospitals.consultants.index',
        'create' => 'hospitals.consultants.create',
        'store' => 'hospitals.consultants.store',
        'edit' => 'hospitals.consultants.edit',
        'update' => 'hospitals.consultants.update',
    ]);
    Route::post('consultants/check-email-address', 'HospitalConsultant@checkAddress')->name('hospitals.consultants.checkEmail');
    Route::get('consultants/update/status/{userId}/{statusCode}', 'HospitalConsultant@updateStatus')->name('hospitals.consultants.updateStatus');

});

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
    Route::post('clinics/list-consultants', 'PhyClinicsController@listConsultants')->name('physician.clinics.listConsultants');

    Route::resource('branches', 'PhyBranchesController')->names([
        'index' => 'physician.branches.index',
        'create' => 'physician.branches.create',
        'edit' => 'physician.branches.edit',
        'store' => 'physician.branches.store',
        'update' => 'physician.branches.update',
    ]);
    Route::get('branches/update/status/{userId}/{statusCode}','PhyBranchesController@updateStatus')->name('physician.branches.updateStatus');

    Route::resource('consultants', 'PhyConsultantsController')->names([
        'index' => 'physician.consultants.index',
        'create' => 'physician.consultants.create',
        'show' => 'physician.consultants.show',
        'edit' => 'physician.consultants.edit',
        'store' => 'physician.consultants.store',
        'update' => 'physician.consultants.update',
    ]);
    Route::get('consultants/update/status/{userId}/{statusCode}','PhyConsultantsController@updateStatus')->name('physician.consultants.updateStatus');
    Route::resource('gallery', 'GalleryController')->names([
        'index' => 'physician.gallery.index',        
        'store' => 'physician.gallery.store',
        'show' => 'physician.gallery.show',
        'update' => 'physician.gallery.update',
    ]);    
    Route::get('gallery/update/status/{userId}/{statusCode}','GalleryController@updateStatus')->name('physician.gallery.updateStatus');        


});

?>