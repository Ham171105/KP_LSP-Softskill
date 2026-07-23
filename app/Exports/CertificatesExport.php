<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class CertificatesExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $category;
    protected $year;
    protected $rowNumber = 0;

    public function __construct(Category $category, $year = null)
    {
        $this->category = $category;
        $this->year = $year;
    }

    public function collection()
    {
        $query = $this->category->certificates()->orderBy('created_at', 'asc');
        
        if ($this->year) {
            $query->whereYear('issue_date', $this->year);
        }
        
        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'NAMA ASESI',
            'JENIS KELAMIN (L/P)',
            'NOMOR BLANKO',
            'NO. REG. SOF',
            'SKEMA',
            'TANGGAL ASESMEN'
        ];
    }

    public function map($certificate): array
    {
        $this->rowNumber++;
        $issueDate = \Carbon\Carbon::parse($certificate->issue_date)->format('d-M-Y');
        
        return [
            $this->rowNumber,
            $certificate->participant_name,
            $certificate->gender,
            $certificate->blanko_number,
            $certificate->registration_number,
            $this->category->name,
            $issueDate
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Style for the header row
        $sheet->getStyle('A1:G1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF1F497D'], // Dark blue color
            ],
        ]);

        // Style for all cells (borders)
        $highestRow = $sheet->getHighestRow();
        $sheet->getStyle('A1:G' . $highestRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);
        
        // Center align the numbers and gender
        $sheet->getStyle('A2:A' . $highestRow)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('C2:C' . $highestRow)->getAlignment()->setHorizontal('center');
    }
}
