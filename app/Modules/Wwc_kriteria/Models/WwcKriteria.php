<?php

namespace App\Modules\Wwc_kriteria\Models;

use Illuminate\Database\Eloquent\Model;

class WwcKriteria extends Model
{
    protected $table = 'wwc_kriteria';
    protected $primaryKey = 'id_kriteria';
    protected $guarded = [];

    public function indikator()
    {
        return $this->hasMany('App\Modules\Wwc_indikator\Models\WwcIndikator', 'id_kriteria', 'id_kriteria');
    }
}
