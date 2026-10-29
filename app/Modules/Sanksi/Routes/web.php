<?php

use Illuminate\Support\Facades\Route;

Route::get('sanksi', 'SanksiController@sanksi')->name('sanksi');
Route::post('tambah_sanksi', 'SanksiController@tambah_sanksi')->name('sanksi.tambah');
Route::post('ubah_sanksi', 'SanksiController@ubah_sanksi')->name('sanksi.ubah');
Route::get('get_ubah_sanksi/{id}', 'SanksiController@get_ubah_sanksi')->name('sanksi.getubah');
Route::get('hapus_sanksi/{id}', 'SanksiController@hapus_sanksi')->name('sanksi.hapus');
