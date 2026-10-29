<?php

namespace App\Modules\Unit\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table = "unit";
    protected $primaryKey = "id_unit";
    protected $guarded = [];

    public function proyek()
    {
        return $this->belongsTo('App\Modules\Proyek\Models\Proyek', 'id_proyek', 'id_proyek');
    }
}

