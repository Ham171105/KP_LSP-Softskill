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
        
        $certificates = $category->certificates()
            ->when($search, function ($query, $search) {
                return $query->where('participant_name', 'like', "%{$search}%")
                             ->orWhere('certificate_number', 'like', "%{$search}%")
                             ->orWhere('registration_number', 'like', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(25)
            ->appends(['search' => $search]);
            
        return view('dashboard.category', compact('category', 'certificates', 'search'));
    }
}
