<?php

namespace App\Modules\Penilaian\Models;

use Illuminate\Database\Eloquent\Model;

class penilaian extends Model
{
    protected $table = "penilaian";
    protected $primaryKey = 'id_penilaian';

    public $timestamps = false;

    public function formPenilaian(){
        return $this->belongsTo('App\Modules\FormPenilaian\Models\formPenilaian', 'form_penilaian_idtable1', 'idform_penilaian');
    }

    public function karyawan()
    {
        return $this->belongsTo('App\Modules\Karyawan\Models\karyawan', 'karyawan_id_karyawan', 'id_karyawan');
    }
}
