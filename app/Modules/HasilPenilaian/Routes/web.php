<?php

use Illuminate\Support\Facades\Route;

Route::get('rekap_presensi', 'HasilPenilaianController@rekap_presensi')->name('rekap_presensi');
Route::get('hasil', function() { return redirect()->route('hasil.keseluruhan'); });
Route::get('hasil/keseluruhan', 'HasilPenilaianController@hasil_keseluruhan')->name('hasil.keseluruhan');
Route::get('hasil/keseluruhan/detail/{id_karyawan}', 'HasilPenilaianController@detail_personil')->name('hasil.keseluruhan.detail');
Route::get('hasil/presensi', 'HasilPenilaianController@nilai_presensi')->name('hasil.presensi');
Route::get('hasil/wawancara', 'HasilPenilaianController@nilai_wawancara')->name('hasil.wawancara');
Route::get('hasil/cbt', '\App\Modules\Cbt_hasil\Controllers\Cbt_hasilController@index')->name('hasil.cbt');
