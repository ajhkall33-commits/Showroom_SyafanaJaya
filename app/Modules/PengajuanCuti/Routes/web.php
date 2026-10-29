<?php

use Illuminate\Support\Facades\Route;

Route::get('pengajuanCuti', 'PengajuanCutiController@pengajuanCutiWithDate')->name('pengajuanCuti');
Route::post('tambah_pengajuanCuti', 'PengajuanCutiController@tambah_pengajuanCuti')->name('pengajuanCuti.tambah');
Route::post('ubah_pengajuanCuti', 'PengajuanCutiController@ubah_pengajuanCuti')->name('pengajuanCuti.ubah');
Route::get('get_ubah_pengajuanCuti/{id}', 'PengajuanCutiController@get_ubah_pengajuanCuti')->name('pengajuanCuti.getubah');
Route::get('hapus_pengajuanCuti/{id}', 'PengajuanCutiController@hapus_pengajuanCuti')->name('pengajuanCuti.hapus');
Route::get('terima_pengajuanCuti/{id}', 'PengajuanCutiController@terima_pengajuanCuti')->name('pengajuanCuti.terima');
Route::get('tolak_pengajuanCuti/{id}', 'PengajuanCutiController@tolak_pengajuanCuti')->name('pengajuanCuti.tolak');
