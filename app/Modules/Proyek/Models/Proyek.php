<?php

namespace App\Modules\Proyek\Models;

use Illuminate\Database\Eloquent\Model;

class Proyek extends Model
{
    protected $table = "proyek";
    protected $primaryKey = "id_proyek";
    protected $guarded = [];

    public function unit()
    {
        return $this->hasMany('App\Modules\Unit\Models\Unit', 'id_proyek', 'id_proyek');
    }
}

