<?php
require 'vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$cert = \App\Models\Certificate::first();
if ($cert) {
    $settings = \App\Models\TemplateSetting::where('category_id', $cert->category_id)->get();
    $cleanSettings = [];
    foreach($settings as $s) {
        $cleanSettings[$s->element] = str_replace('mm', '', $s->y_position);
    }
    echo json_encode($cleanSettings, JSON_PRETTY_PRINT);
} else {
    echo "No cert";
}
