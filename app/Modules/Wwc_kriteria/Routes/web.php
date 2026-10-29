<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'wwc_kriteria', 'as' => 'wwc_kriteria.'], function () {
    Route::get('/', 'Wwc_kriteriaController@index')->name('index');
    Route::post('/LoadData', 'Wwc_kriteriaController@LoadData')->name('load_data');
    Route::get('/EditData/{id?}', 'Wwc_kriteriaController@EditData')->name('edit_data');
    Route::post('/SaveData', 'Wwc_kriteriaController@SaveData')->name('save_data');
    Route::post('/UpdateData/{id?}', 'Wwc_kriteriaController@UpdateData')->name('update_data');
    Route::post('/Delete/{id?}', 'Wwc_kriteriaController@Delete')->name('delete');
    Route::post('/ToggleStatus/{id?}', 'Wwc_kriteriaController@ToggleStatus')->name('toggle_status');
});

// Backward compatibility alias
Route::get('kriteria', function () {
    return redirect()->route('wwc_kriteria.index');
})->name('kriteria');
