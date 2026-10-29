<?php

use Illuminate\Support\Facades\Route;

Route::get('jabatan', 'JabatanController@jabatan')->name('jabatan');
Route::post('tambah_jabatan', 'JabatanController@tambah_jabatan')->name('jabatan.tambah');
Route::post('ubah_jabatan', 'JabatanController@ubah_jabatan')->name('jabatan.ubah');
Route::get('get_ubah_jabatan/{id}', 'JabatanController@get_ubah_jabatan')->name('jabatan.getubah');
Route::get('hapus_jabatan/{id}', 'JabatanController@hapus_jabatan')->name('jabatan.hapus');
