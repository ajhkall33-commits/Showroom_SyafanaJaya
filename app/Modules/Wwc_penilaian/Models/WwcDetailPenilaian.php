<?php

namespace App\Modules\Wwc_penilaian\Models;

use Illuminate\Database\Eloquent\Model;

class WwcDetailPenilaian extends Model
{
    protected $table = 'wwc_detail_penilaian';
    protected $primaryKey = 'id_detail_penilaian';
    public $timestamps = true;

    protected $fillable = [
        'id_penilaian',
        'id_indikator',
        'nilai',
        'skor',
        'catatan',
    ];

    public function penilaian()
    {
        return $this->belongsTo(WwcPenilaian::class, 'id_penilaian', 'id_penilaian');
    }

    public function indikator()
    {
        return $this->belongsTo(\App\Modules\Wwc_indikator\Models\WwcIndikator::class, 'id_indikator', 'id_indikator');
    }
}
