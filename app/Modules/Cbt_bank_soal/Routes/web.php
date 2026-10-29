<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'cbt_bank_soal', 'as' => 'cbt_bank_soal.'], function () {
    Route::get('/', 'Cbt_bank_soalController@index')->name('index');
    Route::post('/LoadData', 'Cbt_bank_soalController@LoadData')->name('load_data');
    Route::post('/LoadUnit', 'Cbt_bank_soalController@LoadUnit')->name('load_unit');
    Route::post('/SaveData', 'Cbt_bank_soalController@SaveData')->name('save_data');
    Route::get('/EditData/{id?}', 'Cbt_bank_soalController@EditData')->name('edit_data');
    Route::post('/UpdateData/{id?}', 'Cbt_bank_soalController@UpdateData')->name('update_data');
    Route::post('/Delete/{id?}', 'Cbt_bank_soalController@Delete')->name('delete');
    Route::post('/ToggleStatus/{id?}', 'Cbt_bank_soalController@ToggleStatus')->name('toggle_status');
    Route::get('/print_soal', 'Cbt_bank_soalController@print_soal')->name('print_soal');
});

// Backward compatibility alias
Route::get('bank_soal', function () {
    return redirect()->route('cbt_bank_soal.index');
})->name('bank_soal');
