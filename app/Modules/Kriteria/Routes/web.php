<?php

use Illuminate\Support\Facades\Route;

Route::get('kriteria', 'KriteriaController@kriteria')->name('kriteria');
Route::post('tambah_kriteria', 'KriteriaController@tambah_kriteria')->name('kriteria.tambah');
Route::post('ubah_kriteria', 'KriteriaController@ubah_kriteria')->name('kriteria.ubah');
Route::get('get_ubah_kriteria/{id}', 'KriteriaController@get_ubah_kriteria')->name('kriteria.getubah');
Route::get('hapus_kriteria/{id}', 'KriteriaController@hapus_kriteria')->name('kriteria.hapus');
