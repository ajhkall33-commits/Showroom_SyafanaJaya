<?php

use Illuminate\Support\Facades\Route;

Route::get('penghargaan', 'PenghargaanController@penghargaan')->name('penghargaan');
Route::post('tambah_penghargaan', 'PenghargaanController@tambah_penghargaan')->name('penghargaan.tambah');
Route::post('ubah_penghargaan', 'PenghargaanController@ubah_penghargaan')->name('penghargaan.ubah');
Route::get('get_ubah_penghargaan/{id}', 'PenghargaanController@get_ubah_penghargaan')->name('penghargaan.getubah');
Route::get('hapus_penghargaan/{id}', 'PenghargaanController@hapus_penghargaan')->name('penghargaan.hapus');
Route::get('terima_penghargaan/{id}', 'PenghargaanController@terima_penghargaan')->name('penghargaan.terima');
Route::get('tolak_penghargaan/{id}', 'PenghargaanController@tolak_penghargaan')->name('penghargaan.tolak');
