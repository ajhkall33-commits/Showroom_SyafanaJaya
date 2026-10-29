<?php

namespace App\Modules\Wwc_penilaian\Models;

use Illuminate\Database\Eloquent\Model;

class WwcPenilaian extends Model
{
    protected $table = 'wwc_penilaian';
    protected $primaryKey = 'id_penilaian';
    public $timestamps = true;

    protected $fillable = [
        'id_form',
        'id_form_assessor',
        'id_peserta',
        'tanggal_mulai',
        'tanggal_selesai',
        'total_nilai',
        'persentase',
        'kesimpulan',
        'rekomendasi',
        'status',
    ];

    public function details()
    {
        return $this->hasMany(WwcDetailPenilaian::class, 'id_penilaian', 'id_penilaian');
    }

    public function form()
    {
        return $this->belongsTo(\App\Modules\Wwc_form_penilaian\Models\WwcFormPenilaian::class, 'id_form', 'id_form');
    }

    public function assessor()
    {
        return $this->belongsTo(\App\Modules\Wwc_form_assessor\Models\WwcFormAssessor::class, 'id_form_assessor', 'id_form_assessor');
    }
}
