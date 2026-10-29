<?php

use Illuminate\Support\Facades\Route;

Route::get('unit', 'UnitController@unit')->name('unit');
Route::post('tambah_unit', 'UnitController@tambah_unit')->name('unit.tambah');
Route::post('ubah_unit', 'UnitController@ubah_unit')->name('unit.ubah');
Route::get('get_ubah_unit/{id}', 'UnitController@get_ubah_unit')->name('unit.getubah');
Route::get('hapus_unit/{id}', 'UnitController@hapus_unit')->name('unit.hapus');
