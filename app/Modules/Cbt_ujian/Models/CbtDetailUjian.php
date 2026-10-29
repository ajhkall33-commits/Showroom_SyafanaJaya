<?php

namespace App\Modules\Cbt_ujian\Models;

use Illuminate\Database\Eloquent\Model;

class CbtDetailUjian extends Model
{
    protected $table = 'cbt_detail_ujian';
    protected $primaryKey = 'id_detail_ujian_cbt';
    protected $guarded = [];

    public function ujian()
    {
        return $this->belongsTo(CbtUjian::class, 'id_ujian_cbt', 'id_ujian_cbt');
    }

    public function bankSoal()
    {
        return $this->belongsTo(\App\Modules\Cbt_bank_soal\Models\CbtBankSoal::class, 'id_bank_soal_cbt', 'id_bank_soal_cbt');
    }
}
