<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::group(['prefix' => 'wwc_form_penilaian'], function () {
        Route::get('/', 'Wwc_form_penilaianController@index')->name('wwc_form_penilaian.index');
        Route::get('/Detail/{id?}', 'Wwc_form_penilaianController@Detail')->name('wwc_form_penilaian.detail');
        Route::post('/LoadData', 'Wwc_form_penilaianController@LoadData')->name('wwc_form_penilaian.loaddata');
        Route::post('/LoadIndikatorByUnitRole', 'Wwc_form_penilaianController@LoadIndikatorByUnitRole')->name('wwc_form_penilaian.loadindikatorbyunitrole');
        Route::post('/LoadRole', 'Wwc_form_penilaianController@LoadRole')->name('wwc_form_penilaian.loadrole');
        Route::get('/EditData/{id?}', 'Wwc_form_penilaianController@EditData')->name('wwc_form_penilaian.editdata');
        Route::get('/GetIndikatorForm/{id?}', 'Wwc_form_penilaianController@GetIndikatorForm')->name('wwc_form_penilaian.getindikatorform');
        Route::post('/SaveData', 'Wwc_form_penilaianController@SaveData')->name('wwc_form_penilaian.savedata');
        Route::post('/UpdateData/{id?}', 'Wwc_form_penilaianController@UpdateData')->name('wwc_form_penilaian.updatedata');
        Route::post('/Publish/{id?}', 'Wwc_form_penilaianController@Publish')->name('wwc_form_penilaian.publish');
        Route::post('/Duplicate/{id?}', 'Wwc_form_penilaianController@Duplicate')->name('wwc_form_penilaian.duplicate');
        Route::post('/Delete/{id?}', 'Wwc_form_penilaianController@Delete')->name('wwc_form_penilaian.delete');
    });

    // Backward compatibility alias for form_penilaian
    Route::group(['prefix' => 'form_penilaian'], function () {
        Route::get('/', 'Wwc_form_penilaianController@index')->name('form_penilaian.index');
        Route::get('/Detail/{id?}', 'Wwc_form_penilaianController@Detail');
        Route::post('/LoadData', 'Wwc_form_penilaianController@LoadData');
        Route::post('/LoadIndikatorByUnitRole', 'Wwc_form_penilaianController@LoadIndikatorByUnitRole');
        Route::post('/LoadRole', 'Wwc_form_penilaianController@LoadRole');
        Route::get('/EditData/{id?}', 'Wwc_form_penilaianController@EditData');
        Route::get('/GetIndikatorForm/{id?}', 'Wwc_form_penilaianController@GetIndikatorForm');
        Route::post('/SaveData', 'Wwc_form_penilaianController@SaveData');
        Route::post('/UpdateData/{id?}', 'Wwc_form_penilaianController@UpdateData');
        Route::post('/Publish/{id?}', 'Wwc_form_penilaianController@Publish');
        Route::post('/Duplicate/{id?}', 'Wwc_form_penilaianController@Duplicate');
        Route::post('/Delete/{id?}', 'Wwc_form_penilaianController@Delete');
    });
});
