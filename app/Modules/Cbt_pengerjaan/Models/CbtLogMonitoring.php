<?php

namespace App\Modules\Cbt_pengerjaan\Models;

use Illuminate\Database\Eloquent\Model;

class CbtLogMonitoring extends Model
{
    protected $table = 'cbt_log_monitoring';
    protected $primaryKey = 'id_log_monitoring_cbt';
    protected $guarded = [];

    public function proses()
    {
        return $this->belongsTo(CbtProsesUjian::class, 'id_proses_ujian_cbt', 'id_proses_ujian_cbt');
    }
}
