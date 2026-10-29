<?php

use Illuminate\Support\Facades\Route;

Route::get('admin', 'adminController@admin')->name('admin');
Route::post('admin', 'adminController@tambah_admin')->name('admin.tambah');
Route::post('ubah_admin', 'adminController@ubah_admin')->name('admin.ubah');
Route::get('get_ubah_admin/{id}', 'adminController@get_ubah_admin')->name('admin.getubah');
Route::get('hapus_admin/{id}', 'adminController@hapus_admin')->name('admin.hapus');
