<?php

use Illuminate\Support\Facades\Route;

Route::get('bank_soal', 'CbtController@bank_soal')->name('bank_soal');
Route::post('tambah_soal', 'CbtController@tambah_soal')->name('bank_soal.tambah');
Route::post('ubah_soal', 'CbtController@ubah_soal')->name('bank_soal.ubah');
Route::get('get_ubah_soal/{id}', 'CbtController@get_ubah_soal')->name('bank_soal.getubah');
Route::get('hapus_soal/{id}', 'CbtController@hapus_soal')->name('bank_soal.hapus');
Route::get('cbt_setting', 'CbtController@cbt_setting')->name('cbt_setting');
Route::post('tambah_cbt_setting', 'CbtController@tambah_setting')->name('cbt_setting.tambah');
Route::post('ubah_cbt_setting', 'CbtController@ubah_setting')->name('cbt_setting.ubah');
Route::get('get_ubah_cbt_setting/{id}', 'CbtController@get_ubah_setting')->name('cbt_setting.getubah');
Route::get('hapus_cbt_setting/{id}', 'CbtController@hapus_setting')->name('cbt_setting.hapus');
Route::get('ujian_cbt', 'CbtController@ujian_cbt')->name('ujian_cbt');
Route::get('ujian_cbt/mulai/{setting_id}', 'CbtController@mulai_ujian')->name('ujian_cbt.mulai');
Route::post('ujian_cbt/submit', 'CbtController@submit_ujian')->name('ujian_cbt.submit');
