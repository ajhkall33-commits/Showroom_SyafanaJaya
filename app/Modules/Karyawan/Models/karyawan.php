<?php

namespace App\Modules\Karyawan\Models;

use Illuminate\Database\Eloquent\Model;

class karyawan extends Model
{
    protected $table = "karyawan";
    protected $primaryKey = "id_karyawan";

    public $timestamps = false;

    public function departemen()
    {
        return $this->belongsTo('App\Modules\Departemen\Models\departemen', 'departemen_id_departemen', 'id_departemen');
    }

    public function jabatan()
    {
        return $this->belongsTo('App\Modules\Jabatan\Models\jabatan', 'jabatan_id_jabatan', 'id_jabatan');
    }

    public function unit()
    {
        return $this->belongsTo('App\Modules\Unit\Models\Unit', 'unit_id_unit', 'id_unit');
    }
  
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id_user', 'id');
    }
}
