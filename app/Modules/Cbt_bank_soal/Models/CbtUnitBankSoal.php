<?php

namespace App\Modules\Cbt_bank_soal\Models;

use Illuminate\Database\Eloquent\Model;

class CbtUnitBankSoal extends Model
{
    protected $table = 'cbt_unit_bank_soal';
    protected $primaryKey = 'id_unit_bank_soal';
    protected $guarded = [];

    public function bankSoal()
    {
        return $this->belongsTo(CbtBankSoal::class, 'id_bank_soal', 'id_bank_soal_cbt');
    }

    public function unit()
    {
        return $this->belongsTo(\App\Modules\Unit\Models\Unit::class, 'id_unit', 'id_unit');
    }

    public function jabatan()
    {
        return $this->belongsTo(\App\Modules\Jabatan\Models\jabatan::class, 'id_role', 'id_jabatan');
    }
}
