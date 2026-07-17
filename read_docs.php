<?php

require __DIR__.'/vendor/autoload.php';

$files = [
    'templates/Kepemimpinan - Depan.docx',
    'templates/Komunikasi  - Depan.docx',
    'templates/Pemecahan Masalah - Depan.docx',
];

foreach ($files as $file) {
    $path = __DIR__ . '/' . $file;
    if (file_exists($path)) {
        echo "=== $file ===\n";
        $phpWord = \PhpOffice\PhpWord\IOFactory::load($path);
        $text = '';
        foreach ($phpWord->getSections() as $section) {
            foreach ($section->getElements() as $element) {
                if (method_exists($element, 'getText')) {
                    $text .= $element->getText() . "\n";
                } elseif (method_exists($element, 'getElements')) {
                    foreach ($element->getElements() as $subElement) {
                        if (method_exists($subElement, 'getText')) {
                            $text .= $subElement->getText() . "\n";
                        }
                    }
                }
            }
        }
        echo substr($text, 0, 500) . "\n\n";
    }
}
