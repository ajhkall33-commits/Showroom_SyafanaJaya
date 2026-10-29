<?php

use Illuminate\Support\Facades\Route;

Route::get('penilaian', 'PenilaianController@penilaianWithDate')->name('penilaian');
Route::post('tambah_penilaian', 'PenilaianController@tambah_penilaian')->name('penilaian.tambah');
Route::post('ubah_penilaian', 'PenilaianController@ubah_penilaian')->name('penilaian.ubah');
Route::get('get_ubah_penilaian/{id}', 'PenilaianController@get_ubah_penilaian')->name('penilaian.getubah');
Route::get('hapus_penilaian/{id}', 'PenilaianController@hapus_penilaian')->name('penilaian.hapus');
Route::post('ubah_penilaian_nilai', 'PenilaianController@ubah_penilaian_nilai')->name('penilaian.ubahNilai');
