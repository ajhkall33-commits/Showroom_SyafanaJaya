<?php

use Illuminate\Support\Facades\Route;

Route::get('departemen', 'DepartemenController@departemen')->name('departemen');
Route::post('tambah_departemen', 'DepartemenController@tambah_departemen')->name('departemen.tambah');
Route::post('ubah_departemen', 'DepartemenController@ubah_departemen')->name('departemen.ubah');
Route::get('get_ubah_departemen/{id}', 'DepartemenController@get_ubah_departemen')->name('departemen.getubah');
Route::get('hapus_departemen/{id}', 'DepartemenController@hapus_departemen')->name('departemen.hapus');
