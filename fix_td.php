<?php
$files = ['pm_back.blade.php', 'kom_back.blade.php', 'kpm_back.blade.php'];
foreach ($files as $file) {
    $path = 'resources/views/certificates/templates/' . $file;
    $content = file_get_contents($path);
    // Add vertical align rule in style tag
    if (strpos($content, 'th, td {') !== false) {
        $content = str_replace('th, td {', "th, td {\n            vertical-align: middle;", $content);
    } else {
        // Find existing table rule and append to it
        $content = preg_replace('/(table\s*\{[^}]*)\}/', "$1\n        }\n        td {\n            vertical-align: middle;\n        }", $content);
    }
    file_put_contents($path, $content);
}
echo "Done";
