<?php

namespace App\Modules\Wwc_form_penilaian\Models;

use Illuminate\Database\Eloquent\Model;

class WwcDetailFormPenilaian extends Model
{
    protected $table = 'wwc_detail_form_penilaian';
    protected $primaryKey = 'id_detail_form';
    public $timestamps = true;

    protected $fillable = [
        'id_form',
        'id_indikator',
        'urutan',
        'status',
    ];

    public function form()
    {
        return $this->belongsTo(WwcFormPenilaian::class, 'id_form', 'id_form');
    }

    public function indikator()
    {
        return $this->belongsTo(\App\Modules\Wwc_indikator\Models\WwcIndikator::class, 'id_indikator', 'id_indikator');
    }
}
