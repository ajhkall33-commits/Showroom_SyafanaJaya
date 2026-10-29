<?php

use Illuminate\Support\Facades\Route;

Route::get('absensi', 'AbsensiController@absensiWithDate')->name('absensi');
Route::post('tambah_absensi', 'AbsensiController@tambah_absensi')->name('absensi.tambah');
Route::post('ubah_absensi', 'AbsensiController@ubah_absensi')->name('absensi.ubah');
Route::get('get_log_absensi/{day}', 'AbsensiController@get_log_absensi')->name('absensi.log');
Route::get('get_absen_absensi/{day}', 'AbsensiController@get_absen_absensi')->name('absensi.absen');
Route::get('get_ubah_absensi/{id}', 'AbsensiController@get_ubah_absensi')->name('absensi.getubah');
Route::get('hapus_absensi/{id}', 'AbsensiController@hapus_absensi')->name('absensi.hapus');
