<?php

namespace App\Modules\Wwc_form_assessor\Models;

use Illuminate\Database\Eloquent\Model;

class WwcFormAssessor extends Model
{
    protected $table = 'wwc_form_assessor';
    protected $primaryKey = 'id_form_assessor';
    public $timestamps = true;

    protected $fillable = [
        'id_form',
        'id_user',
        'urutan',
        'status',
        'assigned_at',
        'catatan',
    ];

    public function form()
    {
        return $this->belongsTo(\App\Modules\Wwc_form_penilaian\Models\WwcFormPenilaian::class, 'id_form', 'id_form');
    }

    public function peserta()
    {
        return $this->hasMany(WwcFormAssessorPeserta::class, 'id_form_assessor', 'id_form_assessor');
    }
}
