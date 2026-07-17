<?php

require __DIR__.'/vendor/autoload.php';

$files = [
    'templates/Kepemimpinan - Belakang.doc',
    'templates/Komunikasi - Belakang.doc',
];

foreach ($files as $file) {
    $path = __DIR__ . '/' . $file;
    if (file_exists($path)) {
        echo "=== $file ===\n";
        // .doc files might not be readable by PhpWord easily, let's try
        try {
            $phpWord = \PhpOffice\PhpWord\IOFactory::load($path, 'MsDoc');
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
            echo substr($text, 0, 1000) . "\n\n";
        } catch (Exception $e) {
            echo "Failed: " . $e->getMessage() . "\n";
        }
    } else {
        echo "File not found: $path\n";
    }
}
