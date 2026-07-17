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

    public function showCategory(Category $category)
    {
        $certificates = $category->certificates()->latest()->get();
        return view('dashboard.category', compact('category', 'certificates'));
    }
}
