<?php

namespace App\Modules\Cbt_hasil\Models;

use Illuminate\Database\Eloquent\Model;

class CbtDetailHasilUjian extends Model
{
    protected $table = 'cbt_detail_hasil_ujian';
    protected $primaryKey = 'id_detail_hasil_ujian_cbt';
    protected $guarded = [];

    public function hasilUjian()
    {
        return $this->belongsTo(CbtHasilUjian::class, 'id_hasil_ujian_cbt', 'id_hasil_ujian_cbt');
    }

    public function bankSoal()
    {
        return $this->belongsTo(\App\Modules\Cbt_bank_soal\Models\CbtBankSoal::class, 'id_bank_soal_cbt', 'id_bank_soal_cbt');
    }
}
