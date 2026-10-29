<?php

namespace App\Modules\Wwc_indikator\Models;

use Illuminate\Database\Eloquent\Model;

class WwcUnitIndikator extends Model
{
    protected $table = 'wwc_unit_indikator';
    protected $primaryKey = 'id_unit_indikator';
    public $timestamps = true;

    protected $fillable = [
        'id_indikator',
        'id_unit',
        'id_role',
    ];

    public function indikator()
    {
        return $this->belongsTo(WwcIndikator::class, 'id_indikator', 'id_indikator');
    }
}
