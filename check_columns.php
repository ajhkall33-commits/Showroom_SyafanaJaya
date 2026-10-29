<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$tables = ['cbt_bank_soal', 'cbt_ujian', 'cbt_hasil_ujian', 'cbt_detail_hasil_ujian', 'cbt_proses_ujian', 'cbt_log_monitoring', 'cbt_detail_ujian', 'cbt_setting_ujian', 'cbt_unit_bank_soal'];

foreach ($tables as $tbl) {
    try {
        $columns = DB::select("SHOW COLUMNS FROM $tbl");
        echo "=== $tbl ===\n";
        foreach ($columns as $col) {
            echo "  {$col->Field} ({$col->Type}) " . ($col->Null == 'YES' ? 'NULL' : 'NOT NULL') . " " . ($col->Key ? "KEY:{$col->Key}" : "") . "\n";
        }
        echo "\n";
    } catch(\Exception $e) {
        echo "=== $tbl === NOT FOUND\n\n";
    }
}
