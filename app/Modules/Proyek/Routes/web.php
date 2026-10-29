<?php

use Illuminate\Support\Facades\Route;

Route::get('proyek', 'ProyekController@proyek')->name('proyek');
Route::post('tambah_proyek', 'ProyekController@tambah_proyek')->name('proyek.tambah');
Route::post('ubah_proyek', 'ProyekController@ubah_proyek')->name('proyek.ubah');
Route::get('get_ubah_proyek/{id}', 'ProyekController@get_ubah_proyek')->name('proyek.getubah');
Route::get('hapus_proyek/{id}', 'ProyekController@hapus_proyek')->name('proyek.hapus');
