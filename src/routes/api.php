<?php
Route::group(['prefix' => 'api/sed'], function () {

        Route::group(['as' => 'Substitution'], function () {
            Route::post('/s',  [\Zhivkov\SedImplementation\Http\Controllers\SedController::class, 'substitution']);

        });

});
