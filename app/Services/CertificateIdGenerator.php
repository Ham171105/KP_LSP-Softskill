<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Certificate;

class CertificateIdGenerator
{
    public static function generate(Category $category, string $issueDate = null)
    {
        // Gunakan tahun dari issue_date jika ada, jika tidak gunakan tahun sekarang
        $year = $issueDate ? date('Y', strtotime($issueDate)) : date('Y');
        $schemaCode = $category->schema_code ?? '0000'; // Fallback if missing
        
        // Urutan nomor terpisah per kategori per tahun
        // Setiap kategori (KPM, KOM, PM) punya urutan sendiri-sendiri
        $lastCertificate = Certificate::where('category_id', $category->id)
            ->whereYear('issue_date', $year)
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
