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
            'participant_email' => 'nullable|email|max:255',
            'issue_date' => 'required|date',
        ]);

        $certificate_number = CertificateIdGenerator::generate($category);

        $certificate = $category->certificates()->create([
            'certificate_number' => $certificate_number,
            'participant_name' => $request->participant_name,
            'participant_email' => $request->participant_email,
            'issue_date' => $request->issue_date,
            'status' => 'active'
        ]);

        return redirect()->route('dashboard.category', $category)->with('success', 'Sertifikat berhasil dibuat dengan ID: ' . $certificate_number);
    }

    public function destroy(Certificate $certificate)
    {
        $category = $certificate->category;
        $certificate->delete();
        return redirect()->route('dashboard.category', $category)->with('success', 'Sertifikat berhasil dihapus.');
    }

    public function print(Certificate $certificate)
    {
        $category = $certificate->category;
        // The view will depend on the category code (KPM, KOM, PM)
        $templateName = strtolower($category->code);
        
        // This will load views like certificates.templates.kpm
        return view('certificates.templates.' . $templateName, compact('certificate'));
    }
}
