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
        
        // 1. Yearly sequence number (merah) - resets every year
        $lastYearlyCertificate = Certificate::where('category_id', $category->id)
            ->whereYear('issue_date', $year)
            ->orderBy('sequence_number', 'desc')
            ->first();

        if (! $lastYearlyCertificate || !$lastYearlyCertificate->sequence_number) {
            $yearlyNumber = 1;
        } else {
            $yearlyNumber = $lastYearlyCertificate->sequence_number + 1;
        }

        // 2. Global sequence number (ijo) - continuous globally (per category)
        $lastGlobalCertificate = Certificate::where('category_id', $category->id)
            ->orderBy('global_sequence_number', 'desc')
            ->first();

        if (! $lastGlobalCertificate || !$lastGlobalCertificate->global_sequence_number) {
            $globalNumber = 1;
        } else {
            $globalNumber = $lastGlobalCertificate->global_sequence_number + 1;
        }

        // Format: 85500 [SCHEMA] 0 [7-DIGIT] [YEAR]
        $bnspNumber = sprintf("85500 %s 0 %07d %s", $schemaCode, $globalNumber, $year);
        
        // Format: SOF.2741.[5-DIGIT] [YEAR]
        $regNumber = sprintf("SOF.2741.%05d %s", $yearlyNumber, $year);

        return [
            'certificate_number' => $bnspNumber,
            'registration_number' => $regNumber,
            'sequence_number' => $yearlyNumber,
            'global_sequence_number' => $globalNumber
        ];
    }
}
