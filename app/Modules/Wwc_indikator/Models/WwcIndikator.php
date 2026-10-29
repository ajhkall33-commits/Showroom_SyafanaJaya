<?php

namespace App\Modules\Wwc_indikator\Models;

use Illuminate\Database\Eloquent\Model;

class WwcIndikator extends Model
{
    protected $table = 'wwc_indikator';
    protected $primaryKey = 'id_indikator';
    public $timestamps = true;

    protected $fillable = [
        'id_kriteria',
        'kode_indikator',
        'nama_indikator',
        'deskripsi',
        'bobot',
        'nilai_min',
        'nilai_max',
        'urutan',
        'status',
    ];

    public function kriteria()
    {
        return $this->belongsTo(\App\Modules\Wwc_kriteria\Models\WwcKriteria::class, 'id_kriteria', 'id_kriteria');
    }

    public function unitIndikators()
    {
        return $this->hasMany(WwcUnitIndikator::class, 'id_indikator', 'id_indikator');
    }
}
