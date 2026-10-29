<?php

use Illuminate\Support\Facades\Route;

Route::get('penjualan', 'PenjualanController@penjualan')->name('penjualan');
Route::post('tambah_penjualan', 'PenjualanController@tambah_penjualan')->name('penjualan.tambah');
Route::post('ubah_penjualan', 'PenjualanController@ubah_penjualan')->name('penjualan.ubah');
Route::get('get_ubah_penjualan/{id}', 'PenjualanController@get_ubah_penjualan')->name('penjualan.getubah');
Route::get('hapus_penjualan/{id}', 'PenjualanController@hapus_penjualan')->name('penjualan.hapus');
Route::get('getPenjualanPerBulan', 'PenjualanController@getPenjualanPerBulan')->name('getPenjualanPerBulan');
