<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'cbt_pengerjaan', 'as' => 'cbt_pengerjaan.'], function () {
    Route::get('/', 'Cbt_pengerjaanController@index')->name('index');
    Route::post('/ValidasiToken', 'Cbt_pengerjaanController@ValidasiToken')->name('validasi_token');
    Route::get('/MulaiUjian/{id_ujian?}', 'Cbt_pengerjaanController@MulaiUjian')->name('mulai_ujian');
    Route::get('/KerjakanUjian/{id_hasil?}', 'Cbt_pengerjaanController@KerjakanUjian')->name('kerjakan_ujian');
    Route::post('/SimpanJawaban', 'Cbt_pengerjaanController@SimpanJawaban')->name('simpan_jawaban');
    Route::post('/SubmitUjian/{id_hasil?}', 'Cbt_pengerjaanController@SubmitUjian')->name('submit_ujian');
    Route::get('/HasilUjian/{id_hasil?}', 'Cbt_pengerjaanController@HasilUjian')->name('hasil_ujian');
    Route::post('/LogMonitoring', 'Cbt_pengerjaanController@LogMonitoring')->name('log_monitoring');
    Route::post('/SimpanWajahAwal', 'Cbt_pengerjaanController@SimpanWajahAwal')->name('simpan_wajah_awal');
});

// Backward compatibility alias
Route::get('ujian_cbt', function () {
    return redirect()->route('cbt_pengerjaan.index');
})->name('ujian_cbt');
