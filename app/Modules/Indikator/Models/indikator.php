<?php

namespace App\Modules\Indikator\Models;

use Illuminate\Database\Eloquent\Model;

class indikator extends Model
{
    protected $table = "indikator";
    protected $primaryKey = 'id_indikator';
    public $timestamps = false;

    public function kriteria()
    {
        return $this->belongsTo('App\Modules\Kriteria\Models\kriteria', 'kriteria_id_kriteria', 'id_kriteria');
    }
}
