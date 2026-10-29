<?php

namespace App\Modules\Wwc_form_penilaian\Models;

use Illuminate\Database\Eloquent\Model;

class WwcFormPenilaian extends Model
{
    protected $table = 'wwc_form_penilaian';
    protected $primaryKey = 'id_form';
    public $timestamps = true;

    protected $fillable = [
        'kode_form',
        'nama_form',
        'id_peserta',
        'id_unit',
        'id_role',
        'tanggal_penilaian',
        'lokasi',
        'catatan',
        'status',
        'id_created_by',
    ];

    public function details()
    {
        return $this->hasMany(WwcDetailFormPenilaian::class, 'id_form', 'id_form');
    }
}
