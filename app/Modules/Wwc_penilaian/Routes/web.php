<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::group(['prefix' => 'wwc_penilaian'], function () {
        Route::get('/', 'Wwc_penilaianController@index')->name('wwc_penilaian.index');
        Route::post('/LoadData', 'Wwc_penilaianController@LoadData')->name('wwc_penilaian.loaddata');
        Route::get('/FormPenilaian/{id_form_assessor?}/{id_peserta?}', 'Wwc_penilaianController@FormPenilaian')->name('wwc_penilaian.formpenilaian');
        Route::post('/SavePenilaian', 'Wwc_penilaianController@SavePenilaian')->name('wwc_penilaian.savepenilaian');
    });

    // Backward compatibility alias for penilaian
    Route::group(['prefix' => 'penilaian'], function () {
        Route::get('/', 'Wwc_penilaianController@index')->name('penilaian.index');
        Route::post('/LoadData', 'Wwc_penilaianController@LoadData');
        Route::get('/FormPenilaian/{id_form_assessor?}/{id_peserta?}', 'Wwc_penilaianController@FormPenilaian');
        Route::post('/SavePenilaian', 'Wwc_penilaianController@SavePenilaian');
    });
});
