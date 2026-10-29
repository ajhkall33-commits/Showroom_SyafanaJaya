<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'cbt_hasil', 'as' => 'cbt_hasil.'], function () {
    Route::get('/', 'Cbt_hasilController@index')->name('index');
    Route::post('/LoadData', 'Cbt_hasilController@LoadData')->name('load_data');
    Route::post('/LoadUjianList', 'Cbt_hasilController@LoadUjianList')->name('load_ujian_list');
    Route::get('/DetailHasil/{id_hasil?}', 'Cbt_hasilController@DetailHasil')->name('detail_hasil');
    Route::post('/StatistikUjian', 'Cbt_hasilController@StatistikUjian')->name('statistik_ujian');
    Route::get('/DetailMonitoring/{id_ujian?}/{id_user?}', 'Cbt_hasilController@DetailMonitoring')->name('detail_monitoring');
    Route::get('/CetakLaporan', 'Cbt_hasilController@CetakLaporan')->name('cetak_laporan');
});
