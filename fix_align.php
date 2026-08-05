<?php
$files = ['pm_back.blade.php', 'kom_back.blade.php', 'kpm_back.blade.php'];
foreach ($files as $file) {
    $path = 'resources/views/certificates/templates/' . $file;
    $content = file_get_contents($path);
    $content = str_replace('class="text-center"', 'style="text-align: center;"', $content);
    file_put_contents($path, $content);
}
echo 'Done';
