<?php

namespace App\Modules\Cbt_hasil\Models;

use Illuminate\Database\Eloquent\Model;

class CbtHasilUjian extends Model
{
    protected $table = 'cbt_hasil_ujian';
    protected $primaryKey = 'id_hasil_ujian_cbt';
    protected $guarded = [];

    public function ujian()
    {
        return $this->belongsTo(\App\Modules\Cbt_ujian\Models\CbtUjian::class, 'id_ujian_cbt', 'id_ujian_cbt');
    }

    public function user()
    {
        return $this->belongsTo(\App\User::class, 'id_user', 'id');
    }

    public function details()
    {
        return $this->hasMany(CbtDetailHasilUjian::class, 'id_hasil_ujian_cbt', 'id_hasil_ujian_cbt');
    }
}
