<?php

use Illuminate\Support\Facades\Route;

Route::get('indikator', 'IndikatorController@indikator')->name('indikator');
Route::post('tambah_indikator', 'IndikatorController@tambah_indikator')->name('indikator.tambah');
Route::post('ubah_indikator', 'IndikatorController@ubah_indikator')->name('indikator.ubah');
Route::get('get_ubah_indikator/{id}', 'IndikatorController@get_ubah_indikator')->name('indikator.getubah');
Route::get('hapus_indikator/{id}', 'IndikatorController@hapus_indikator')->name('indikator.hapus');
