<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'cbt_ujian', 'as' => 'cbt_ujian.'], function () {
    Route::get('/', 'Cbt_ujianController@index')->name('index');
    Route::post('/LoadData', 'Cbt_ujianController@LoadData')->name('load_data');
    Route::post('/LoadBankSoal', 'Cbt_ujianController@LoadBankSoal')->name('load_bank_soal');
    Route::post('/LoadRole', 'Cbt_ujianController@LoadRole')->name('load_role');
    Route::get('/LoadSoalTerpilih/{id_ujian?}', 'Cbt_ujianController@LoadSoalTerpilih')->name('load_soal_terpilih');
    Route::post('/SaveData', 'Cbt_ujianController@SaveData')->name('save_data');
    Route::get('/EditData/{id?}', 'Cbt_ujianController@EditData')->name('edit_data');
    Route::post('/UpdateData/{id?}', 'Cbt_ujianController@UpdateData')->name('update_data');
    Route::post('/RegenerateToken/{id?}', 'Cbt_ujianController@RegenerateToken')->name('regenerate_token');
    Route::post('/PublishUjian/{id?}', 'Cbt_ujianController@PublishUjian')->name('publish_ujian');
    Route::post('/TutupUjian/{id?}', 'Cbt_ujianController@TutupUjian')->name('tutup_ujian');
    Route::post('/Delete/{id?}', 'Cbt_ujianController@Delete')->name('delete');
    Route::get('/GetDetailSoalUjian/{id?}', 'Cbt_ujianController@GetDetailSoalUjian')->name('detail_soal');
    Route::post('/PreviewSoalTerpilih', 'Cbt_ujianController@PreviewSoalTerpilih')->name('preview_soal');
});

// Backward compatibility alias
Route::get('cbt_setting', function () {
    return redirect()->route('cbt_ujian.index');
})->name('cbt_setting');
