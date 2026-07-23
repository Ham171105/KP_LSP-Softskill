<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('certificates')->get();
        return view('dashboard.index', compact('categories'));
    }

    public function showCategory(Request $request, Category $category)
    {
        $search = $request->input('search');
        $year = $request->input('year');
        
        // Ambil daftar tahun unik dari sertifikat di kategori ini
        $driver = \Illuminate\Support\Facades\DB::connection()->getDriverName();
        $selectRaw = $driver === 'sqlite' ? "strftime('%Y', issue_date) as year" : "YEAR(issue_date) as year";
        
        $years = $category->certificates()
            ->selectRaw($selectRaw)
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');
        
        $certificates = $category->certificates()
            ->when($search, function ($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('participant_name', 'like', "%{$search}%")
                      ->orWhere('certificate_number', 'like', "%{$search}%")
                      ->orWhere('registration_number', 'like', "%{$search}%")
                      ->orWhere('blanko_number', 'like', "%{$search}%");
                });
            })
            ->when($year, function ($query, $year) {
                return $query->whereYear('issue_date', $year);
            })
            ->orderBy('id', 'desc')
            ->paginate(25)
            ->appends(['search' => $search, 'year' => $year]);
            
        return view('dashboard.category', compact('category', 'certificates', 'search', 'years', 'year'));
    }
}
