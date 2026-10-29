<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== DATABASE TABLES ===\n";
$tables = DB::select('SHOW TABLES');
foreach($tables as $t) {
    $vals = get_object_vars($t);
    $name = array_values($vals)[0];
    echo $name . "\n";
}

echo "\n=== OLD WAWANCARA TABLES CHECK ===\n";
$old_tables = ['kriteria', 'indikator', 'form_penilaian', 'detil_form_penilaian', 'penilaian'];
foreach($old_tables as $tbl) {
    try {
        echo "=== $tbl ===\n";
        $cols = DB::select("DESCRIBE $tbl");
        foreach($cols as $c) {
            echo "  {$c->Field} ({$c->Type})\n";
        }
        echo "  Row Count: " . DB::table($tbl)->count() . "\n";
    } catch(\Exception $e) {
        echo "$tbl: ERROR - " . $e->getMessage() . "\n";
    }
}


