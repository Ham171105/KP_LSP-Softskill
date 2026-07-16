<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Certificate;

class CertificateIdGenerator
{
    public static function generate(Category $category)
    {
        $year = date('Y');
        $prefix = $category->code . '-' . $year . '-';

        $lastCertificate = Certificate::where('certificate_number', 'like', $prefix . '%')
            ->orderBy('id', 'desc')
            ->first();

        if (! $lastCertificate) {
            $number = 1;
        } else {
            $lastNumber = (int) substr($lastCertificate->certificate_number, strlen($prefix));
            $number = $lastNumber + 1;
        }

        return $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}
