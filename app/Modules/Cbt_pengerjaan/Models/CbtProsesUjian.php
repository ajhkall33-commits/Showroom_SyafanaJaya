<?php

namespace App\Modules\Cbt_pengerjaan\Models;

use Illuminate\Database\Eloquent\Model;

class CbtProsesUjian extends Model
{
    protected $table = 'cbt_proses_ujian';
    protected $primaryKey = 'id_proses_ujian_cbt';
    protected $guarded = [];

    public function ujian()
    {
        return $this->belongsTo(\App\Modules\Cbt_ujian\Models\CbtUjian::class, 'id_ujian_cbt', 'id_ujian_cbt');
    }

    public function user()
    {
        return $this->belongsTo(\App\User::class, 'id_user', 'id');
    }

    public function logs()
    {
        return $this->hasMany(CbtLogMonitoring::class, 'id_proses_ujian_cbt', 'id_proses_ujian_cbt');
    }
}
