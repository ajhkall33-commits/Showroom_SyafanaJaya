<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::group(['prefix' => 'wwc_indikator'], function () {
        Route::get('/', 'Wwc_indikatorController@index')->name('wwc_indikator.index');
        Route::post('/LoadData', 'Wwc_indikatorController@LoadData')->name('wwc_indikator.loaddata');
        Route::get('/GetByKriteria/{id?}', 'Wwc_indikatorController@GetByKriteria')->name('wwc_indikator.getbykriteria');
        Route::get('/GetAllAktif', 'Wwc_indikatorController@GetAllAktif')->name('wwc_indikator.getallaktif');
        Route::get('/EditData/{id?}', 'Wwc_indikatorController@EditData')->name('wwc_indikator.editdata');
        Route::post('/GetByUnitRole', 'Wwc_indikatorController@GetByUnitRole')->name('wwc_indikator.getbyunitrole');
        Route::post('/SaveData', 'Wwc_indikatorController@SaveData')->name('wwc_indikator.savedata');
        Route::post('/UpdateData/{id?}', 'Wwc_indikatorController@UpdateData')->name('wwc_indikator.updatedata');
        Route::post('/Delete/{id?}', 'Wwc_indikatorController@Delete')->name('wwc_indikator.delete');
    });

    // Backward compatibility alias for indikator
    Route::group(['prefix' => 'indikator'], function () {
        Route::get('/', 'Wwc_indikatorController@index')->name('indikator.index');
        Route::post('/LoadData', 'Wwc_indikatorController@LoadData');
        Route::get('/GetByKriteria/{id?}', 'Wwc_indikatorController@GetByKriteria');
        Route::get('/GetAllAktif', 'Wwc_indikatorController@GetAllAktif');
        Route::get('/EditData/{id?}', 'Wwc_indikatorController@EditData');
        Route::post('/GetByUnitRole', 'Wwc_indikatorController@GetByUnitRole');
        Route::post('/SaveData', 'Wwc_indikatorController@SaveData');
        Route::post('/UpdateData/{id?}', 'Wwc_indikatorController@UpdateData');
        Route::post('/Delete/{id?}', 'Wwc_indikatorController@Delete');
    });
});
