<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$cols = DB::select('DESCRIBE wwc_form_assessor');
echo "Columns in wwc_form_assessor:\n";
foreach ($cols as $c) {
    echo "  - " . $c->Field . " (" . $c->Type . ")" . ($c->Null === 'NO' ? ' NOT NULL' : '') . "\n";
}
