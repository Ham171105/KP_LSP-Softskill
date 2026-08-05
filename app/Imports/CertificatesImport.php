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
    public $duplicates = [];
    public $updated_blankos = 0;

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
            
            $existingCert = \App\Models\Certificate::where('category_id', $this->category->id)
                ->where('participant_name', $name)
                ->first();
                
            $blanko = trim($row['nomor_blanko'] ?? '');

            if ($existingCert) {
                if (!empty($blanko) && $existingCert->blanko_number !== $blanko) {
                    $existingCert->update(['blanko_number' => $blanko]);
                    $this->updated_blankos++;
                } else {
                    $this->duplicates[] = $name;
                }
                continue;
            }
            
            $rawDate = $row['tanggal_asesmen'] ?? '';
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

            // Generate IDs (fallback)
            $generatedIds = CertificateIdGenerator::generate($this->category, $issueDate);

            // Override with Excel data if available
            $rawReg = trim($row['no_reg_sof'] ?? '');
            if (!empty($rawReg)) {
                if (preg_match('/SOF\.2741\.(\d+)\s+(\d{4})/i', $rawReg, $matches)) {
                    $seq = (int) $matches[1];
                    $yr = $matches[2];
                    
                    $generatedIds['sequence_number'] = $seq;
                    $generatedIds['global_sequence_number'] = $seq;
                    $generatedIds['registration_number'] = sprintf("SOF.2741.%05d %s", $seq, $yr);
                    
                    $schemaCode = $this->category->schema_code ?? '0000';
                    $generatedIds['certificate_number'] = sprintf("85500 %s 0 %07d %s", $schemaCode, $seq, $yr);
                } else {
                    // Fallback to literal string if regex fails, strip 'No. Reg. ' if present
                    $cleanReg = trim(str_ireplace('No. Reg.', '', $rawReg));
                    $generatedIds['registration_number'] = $cleanReg;
                }
            }

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
