<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Certificate;

class CertificateIdGenerator
{
    public static function generate(Category $category)
    {
        $year = date('Y');
        $schemaCode = $category->schema_code ?? '0000'; // Fallback if missing
        
        // Find the last certificate in the same year for ALL categories,
        // or just the same category? The user's numbers (0000012, 0000055) 
        // seem like a global sequence for the LSP. Let's make it global for the year.
        $lastCertificate = Certificate::whereYear('issue_date', $year)
            ->orderBy('sequence_number', 'desc')
            ->first();

        if (! $lastCertificate || !$lastCertificate->sequence_number) {
            $number = 1;
        } else {
            $number = $lastCertificate->sequence_number + 1;
        }

        // Format: 85500 [SCHEMA] 0 [7-DIGIT] [YEAR]
        $bnspNumber = sprintf("85500 %s 0 %07d %s", $schemaCode, $number, $year);
        
        // Format: SOF.2741.[5-DIGIT] [YEAR]
        $regNumber = sprintf("SOF.2741.%05d %s", $number, $year);

        return [
            'certificate_number' => $bnspNumber,
            'registration_number' => $regNumber,
            'sequence_number' => $number
        ];
    }
}
