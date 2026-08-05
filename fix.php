<?php
$pm = file_get_contents('resources/views/certificates/templates/pm_back.blade.php');
$kom = file_get_contents('resources/views/certificates/templates/kom_back.blade.php');
$kpm = file_get_contents('resources/views/certificates/templates/kpm_back.blade.php');

preg_match('/<table.*?<\/table>/s', $kom, $komMatches);
preg_match('/<table.*?<\/table>/s', $kpm, $kpmMatches);

$newKom = preg_replace('/<table.*?<\/table>/s', $komMatches[0], $pm);
$newKpm = preg_replace('/<table.*?<\/table>/s', $kpmMatches[0], $pm);

file_put_contents('resources/views/certificates/templates/kom_back.blade.php', $newKom);
file_put_contents('resources/views/certificates/templates/kpm_back.blade.php', $newKpm);
echo "Berhasil memperbaiki kom_back dan kpm_back.\n";
