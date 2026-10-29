<?php

use Illuminate\Support\Facades\Route;

Route::get('karyawan', 'KaryawanController@karyawan')->name('karyawan');
Route::post('tambah_karyawan', 'KaryawanController@tambah_karyawan')->name('karyawan.tambah');
Route::post('ubah_karyawan', 'KaryawanController@ubah_karyawan')->name('karyawan.ubah');
Route::get('get_ubah_karyawan/{id}', 'KaryawanController@get_ubah_karyawan')->name('karyawan.getubah');
Route::get('hapus_karyawan/{id}', 'KaryawanController@hapus_karyawan')->name('karyawan.hapus');
