<?php

namespace App\Imports;

use App\Models\Category;
use App\Services\CertificateIdGenerator;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class CertificatesImport implements ToCollection, WithHeadingRow
{
    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $name = trim($row['nama_asesi'] ?? '');
            if (empty($name)) {
                continue; // Skip if no name
            }

            // Filter by skema (category name)
            $skemaRow = strtolower(trim($row['skema'] ?? ''));
            $categoryName = strtolower(trim($this->category->name));
            
            // Skip if the skema in excel doesn't match the current category
            if (!empty($skemaRow) && !str_contains($skemaRow, $categoryName) && !str_contains($categoryName, $skemaRow)) {
                continue; 
            }

            $gender = strtoupper(trim($row['jenis_kelamin_lp'] ?? ''));
            if (!in_array($gender, ['L', 'P'])) {
                $gender = null;
            }
            
            $blanko = trim($row['nomor_blanko'] ?? '');
            $rawDate = $row['tanggal_asesmen'] ?? '';
            
            $issueDate = date('Y-m-d'); // default
            
            if (!empty($rawDate)) {
                try {
                    if (is_numeric($rawDate)) {
                        // Excel date format (numeric)
                        $issueDate = Date::excelToDateTimeObject($rawDate)->format('Y-m-d');
                    } else {
                        // String date format
                        $issueDate = \Carbon\Carbon::parse($rawDate)->format('Y-m-d');
                    }
                } catch (\Exception $e) {
                    // Keep default
                }
            }

            // Generate IDs
            $generatedIds = CertificateIdGenerator::generate($this->category, $issueDate);

            $this->category->certificates()->create([
                'certificate_number' => $generatedIds['certificate_number'],
                'registration_number' => $generatedIds['registration_number'],
                'sequence_number' => $generatedIds['sequence_number'],
                'global_sequence_number' => $generatedIds['global_sequence_number'],
                'participant_name' => $name,
                'gender' => $gender,
                'blanko_number' => $blanko,
                'issue_date' => $issueDate,
                'status' => 'active'
            ]);
        }
    }
}
