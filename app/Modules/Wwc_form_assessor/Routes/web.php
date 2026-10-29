<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::group(['prefix' => 'wwc_form_assessor'], function () {
        Route::get('/', 'Wwc_form_assessorController@index')->name('wwc_form_assessor.index');
        Route::post('/LoadData', 'Wwc_form_assessorController@LoadData')->name('wwc_form_assessor.loaddata');
        Route::get('/LoadAssessor/{id?}', 'Wwc_form_assessorController@LoadAssessor')->name('wwc_form_assessor.loadassessor');
        Route::get('/GetListUnit', 'Wwc_form_assessorController@GetListUnit')->name('wwc_form_assessor.getlistunit');
        Route::get('/GetAvailableUser/{id?}', 'Wwc_form_assessorController@GetAvailableUser')->name('wwc_form_assessor.getavailableuser');
        Route::get('/GetPesertaForm/{id_form?}/{id_assessor?}', 'Wwc_form_assessorController@GetPesertaForm')->name('wwc_form_assessor.getpesertaform');
        Route::post('/AssignAssessor', 'Wwc_form_assessorController@AssignAssessor')->name('wwc_form_assessor.assignassessor');
        Route::post('/UpdatePesertaAssessor', 'Wwc_form_assessorController@UpdatePesertaAssessor')->name('wwc_form_assessor.updatepesertaassessor');
        Route::post('/RemoveAssessor/{id?}', 'Wwc_form_assessorController@RemoveAssessor')->name('wwc_form_assessor.removeassessor');
    });

    // Backward compatibility alias for form_assessor
    Route::group(['prefix' => 'form_assessor'], function () {
        Route::get('/', 'Wwc_form_assessorController@index')->name('form_assessor.index');
        Route::post('/LoadData', 'Wwc_form_assessorController@LoadData');
        Route::get('/LoadAssessor/{id?}', 'Wwc_form_assessorController@LoadAssessor');
        Route::get('/GetListUnit', 'Wwc_form_assessorController@GetListUnit');
        Route::get('/GetAvailableUser/{id?}', 'Wwc_form_assessorController@GetAvailableUser');
        Route::get('/GetPesertaForm/{id_form?}/{id_assessor?}', 'Wwc_form_assessorController@GetPesertaForm');
        Route::post('/AssignAssessor', 'Wwc_form_assessorController@AssignAssessor');
        Route::post('/UpdatePesertaAssessor', 'Wwc_form_assessorController@UpdatePesertaAssessor');
        Route::post('/RemoveAssessor/{id?}', 'Wwc_form_assessorController@RemoveAssessor');
    });
});
