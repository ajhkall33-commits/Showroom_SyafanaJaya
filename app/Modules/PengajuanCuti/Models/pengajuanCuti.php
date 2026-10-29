<?php

namespace App\Modules\PengajuanCuti\Models;

use Illuminate\Database\Eloquent\Model;

class pengajuanCuti extends Model
{
    protected $table = "pengajuan_cuti";
    protected $primaryKey = 'idpengajuan_cuti';

    public $timestamps = false;

    public function absensi()
    {
        return $this->belongsTo('App\Modules\Absensi\Models\absensi', 'absensi_id_absensi', 'id_absensi');
    }

    public function karyawan()
    {
        return $this->belongsTo('App\Modules\Karyawan\Models\karyawan', 'karyawan_id_karyawan', 'id_karyawan');
    }
}
