<?php
require 'vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$certificate = \App\Models\Certificate::first();
if ($certificate) {
    $category = $certificate->category;
    $templateName = strtolower($category->code) . '_back';
    
    $settings = \App\Models\TemplateSetting::where('category_id', $category->id)->get();
    
    $cleanSettings = [];
    $fontSettings = [];
    $xSettings = [];
    $customTextSettings = [];
    $fontFamilySettings = [];
    $boldSettings = [];
    $italicSettings = [];
    $textAlignSettings = [];
    $colorSettings = [];
    $underlineSettings = [];
    
    $html = view('certificates.templates.' . $templateName, compact('certificate', 'cleanSettings', 'fontSettings', 'xSettings', 'customTextSettings', 'fontFamilySettings', 'boldSettings', 'italicSettings', 'textAlignSettings', 'colorSettings', 'underlineSettings', 'settings'))->render();
    
    file_put_contents('rendered.html', $html);
    echo "Rendered HTML saved to rendered.html\n";
} else {
    echo "No cert\n";
}
