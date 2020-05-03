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
});

?>