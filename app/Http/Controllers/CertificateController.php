<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Certificate;
use App\Services\CertificateIdGenerator;
use App\Exports\CertificatesExport;
use App\Imports\CertificatesImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CertificateController extends Controller
{
    public function store(Request $request, Category $category)
    {
        $request->validate([
            'participant_name' => 'required|string|max:255',
            'certificate_number' => 'required|string|max:255',
            'registration_number' => 'required|string|max:255',
            'issue_date' => 'required|date',
            'blanko_number' => 'nullable|string|max:255',
            'gender' => 'nullable|in:L,P',
        ]);

        $seq = null;
        $globalSeq = null;

        if (preg_match('/SOF\.2741\.(\d+)/i', $request->registration_number, $matches)) {
            $seq = (int) $matches[1];
        }

        if (preg_match('/85500\s+\w+\s+0\s+(\d+)/i', $request->certificate_number, $matches)) {
            $globalSeq = (int) $matches[1];
        }

        $generatedIds = CertificateIdGenerator::generate($category, $request->issue_date);
        if ($seq === null) $seq = $generatedIds['sequence_number'];
        if ($globalSeq === null) $globalSeq = $generatedIds['global_sequence_number'];

        $certificate = $category->certificates()->create([
            'certificate_number' => $request->certificate_number,
            'registration_number' => $request->registration_number,
            'sequence_number' => $seq,
            'global_sequence_number' => $globalSeq,
            'participant_name' => $request->participant_name,
            'blanko_number' => $request->blanko_number,
            'gender' => $request->gender,
            'issue_date' => $request->issue_date,
            'status' => 'active'
        ]);

        return redirect()->route('dashboard.category', $category)->with('success', 'Sertifikat berhasil dibuat dengan ID: ' . $certificate->certificate_number);
    }

    public function update(Request $request, Certificate $certificate)
    {
        $request->validate([
            'participant_name' => 'required|string|max:255',
            'certificate_number' => 'required|string|max:255',
            'registration_number' => 'required|string|max:255',
            'issue_date' => 'required|date',
            'blanko_number' => 'nullable|string|max:255',
            'gender' => 'nullable|in:L,P',
        ]);

        $seq = $certificate->sequence_number;
        $globalSeq = $certificate->global_sequence_number;

        if (preg_match('/SOF\.2741\.(\d+)/i', $request->registration_number, $matches)) {
            $seq = (int) $matches[1];
        }

        if (preg_match('/85500\s+\w+\s+0\s+(\d+)/i', $request->certificate_number, $matches)) {
            $globalSeq = (int) $matches[1];
        }

        $certificate->update([
            'participant_name' => $request->participant_name,
            'certificate_number' => $request->certificate_number,
            'registration_number' => $request->registration_number,
            'sequence_number' => $seq,
            'global_sequence_number' => $globalSeq,
            'blanko_number' => $request->blanko_number,
            'gender' => $request->gender,
            'issue_date' => $request->issue_date,
        ]);

        return redirect()->back()->with('success', 'Sertifikat berhasil diperbarui.');
    }

    public function destroy(Certificate $certificate)
    {
        $category = $certificate->category;
        $certificate->delete();
        return redirect()->route('dashboard.category', $category)->with('success', 'Sertifikat berhasil dihapus.');
    }

    public function export(Request $request, Category $category)
    {
        $year = $request->input('year');
        $filename = "Sertifikat_{$category->code}_" . ($year ? "{$year}_" : "") . date('Ymd_His') . ".xlsx";
        return Excel::download(new CertificatesExport($category, $year), $filename);
    }

    public function import(Request $request, Category $category)
    {
        $file = $request->file('excel_file');
        if ($file && !$file->isValid()) {
            $errorMessage = $file->getErrorMessage();
            return redirect()->back()->with('error', "Upload Gagal (Sistem): " . $errorMessage);
        }

        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new CertificatesImport($category), $request->file('excel_file'));
            return redirect()->back()->with('success', "Berhasil mengimpor sertifikat baru.");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', "Gagal mengimpor file: " . $e->getMessage());
        }
    }

    public function printFront(Certificate $certificate)
    {
        $category = $certificate->category;
        $templateName = strtolower($category->code) . '_front';
        
        $settings = \App\Models\TemplateSetting::where('category_id', $category->id)->get();
        
        $cleanSettings = [];
        $fontSettings = [];
        $xSettings = [];
        $customTextSettings = [];
        foreach($settings as $setting) {
            $cleanSettings[$setting->element] = str_replace('mm', '', $setting->y_position);
            if ($setting->font_size) {
                $fontSettings[$setting->element] = str_replace('pt', '', $setting->font_size);
            }
            if ($setting->x_position) {
                $xSettings[$setting->element] = str_replace('mm', '', $setting->x_position);
            }
            if ($setting->custom_text !== null) {
                $customTextSettings[$setting->element] = $setting->custom_text;
            }
        }

        return view('certificates.templates.' . $templateName, compact('certificate', 'cleanSettings', 'fontSettings', 'xSettings', 'customTextSettings', 'settings'));
    }

    public function printBack(Certificate $certificate)
    {
        $category = $certificate->category;
        $templateName = strtolower($category->code) . '_back';
        
        $settings = \App\Models\TemplateSetting::where('category_id', $category->id)->get();
        
        $cleanSettings = [];
        $fontSettings = [];
        $xSettings = [];
        $customTextSettings = [];
        foreach($settings as $setting) {
            $cleanSettings[$setting->element] = str_replace('mm', '', $setting->y_position);
            if ($setting->font_size) {
                $fontSettings[$setting->element] = str_replace('pt', '', $setting->font_size);
            }
            if ($setting->x_position) {
                $xSettings[$setting->element] = str_replace('mm', '', $setting->x_position);
            }
            if ($setting->custom_text !== null) {
                $customTextSettings[$setting->element] = $setting->custom_text;
            }
        }

        return view('certificates.templates.' . $templateName, compact('certificate', 'cleanSettings', 'fontSettings', 'xSettings', 'customTextSettings', 'settings'));
    }

}
