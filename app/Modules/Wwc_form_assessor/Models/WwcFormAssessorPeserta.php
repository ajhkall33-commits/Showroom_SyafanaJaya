<?php

namespace App\Modules\Wwc_form_assessor\Models;

use Illuminate\Database\Eloquent\Model;

class WwcFormAssessorPeserta extends Model
{
    protected $table = 'wwc_form_assessor_peserta';
    protected $primaryKey = 'id_form_assessor_peserta';
    public $timestamps = true;

    protected $fillable = [
        'id_form_assessor',
        'id_peserta',
    ];

    public function assessor()
    {
        return $this->belongsTo(WwcFormAssessor::class, 'id_form_assessor', 'id_form_assessor');
    }
}
