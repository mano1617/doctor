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

});

?>