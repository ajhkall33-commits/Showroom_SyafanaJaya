<?php

namespace App\Modules\Cbt_bank_soal\Models;

use Illuminate\Database\Eloquent\Model;

class CbtBankSoal extends Model
{
    protected $table = 'cbt_bank_soal';
    protected $primaryKey = 'id_bank_soal_cbt';
    protected $guarded = [];

    public function units()
    {
        return $this->hasMany(CbtUnitBankSoal::class, 'id_bank_soal', 'id_bank_soal_cbt');
    }

    public function detailUjian()
    {
        return $this->hasMany(\App\Modules\Cbt_ujian\Models\CbtDetailUjian::class, 'id_bank_soal_cbt', 'id_bank_soal_cbt');
    }
}
