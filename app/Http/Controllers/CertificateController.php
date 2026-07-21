<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Certificate;
use App\Services\CertificateIdGenerator;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function store(Request $request, Category $category)
    {
        $request->validate([
            'participant_name' => 'required|string|max:255',
            'issue_date' => 'required|date',
        ]);

        $generatedIds = CertificateIdGenerator::generate($category, $request->issue_date);

        $certificate = $category->certificates()->create([
            'certificate_number' => $generatedIds['certificate_number'],
            'registration_number' => $generatedIds['registration_number'],
            'sequence_number' => $generatedIds['sequence_number'],
            'global_sequence_number' => $generatedIds['global_sequence_number'],
            'participant_name' => $request->participant_name,
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
            'issue_date' => 'required|date',
        ]);

        $certificate->update([
            'participant_name' => $request->participant_name,
            'certificate_number' => $request->certificate_number,
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

    public function printFront(Certificate $certificate)
    {
        $category = $certificate->category;
        $templateName = strtolower($category->code) . '_front';
        return view('certificates.templates.' . $templateName, compact('certificate'));
    }

    public function printBack(Certificate $certificate)
    {
        $category = $certificate->category;
        $templateName = strtolower($category->code) . '_back';
        return view('certificates.templates.' . $templateName, compact('certificate'));
    }
}
