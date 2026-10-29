<?php

use Illuminate\Support\Facades\Route;

Route::get('form_penilaian', 'FormPenilaianController@form_penilaian')->name('form_penilaian');
Route::post('tambah_form_penilaian', 'FormPenilaianController@tambah_form_penilaian')->name('form_penilaian.tambah');
Route::post('ubah_form_penilaian', 'FormPenilaianController@ubah_form_penilaian')->name('form_penilaian.ubah');
Route::get('get_ubah_form_penilaian/{id}', 'FormPenilaianController@get_ubah_form_penilaian')->name('form_penilaian.getubah');
Route::get('hapus_form_penilaian/{id}', 'FormPenilaianController@hapus_form_penilaian')->name('form_penilaian.hapus');
Route::get('get_ubah_detil_form_penilaian/{id}', 'FormPenilaianController@get_ubah_detil_form_penilaian')->name('form_detil_penilaian.getubah');
Route::get('hapus_detil_form_penilaian/{id}', 'FormPenilaianController@hapus_detil_form_penilaian')->name('detil_form_penilaian.hapus');
Route::post('tambah_detil_form_penilaian', 'FormPenilaianController@tambah_detil_form_penilaian')->name('detil_form_penilaian.tambah');
