<?php

namespace App\Modules\Cbt_ujian\Models;

use Illuminate\Database\Eloquent\Model;

class CbtUjian extends Model
{
    protected $table = 'cbt_ujian';
    protected $primaryKey = 'id_ujian_cbt';
    protected $guarded = [];

    public function unit()
    {
        return $this->belongsTo(\App\Modules\Unit\Models\Unit::class, 'id_unit', 'id_unit');
    }

    public function role()
    {
        return $this->belongsTo(\App\Modules\Jabatan\Models\jabatan::class, 'id_role', 'id_jabatan');
    }

    public function details()
    {
        return $this->hasMany(CbtDetailUjian::class, 'id_ujian_cbt', 'id_ujian_cbt');
    }

    public function hasil()
    {
        return $this->hasMany(\App\Modules\Cbt_hasil\Models\CbtHasilUjian::class, 'id_ujian_cbt', 'id_ujian_cbt');
    }
}
