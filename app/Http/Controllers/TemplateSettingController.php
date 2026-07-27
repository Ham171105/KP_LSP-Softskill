<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\TemplateSetting;
use Illuminate\Http\Request;

class TemplateSettingController extends Controller
{
    public function store(Request $request, Category $category)
    {
        $settings = $request->input('settings', []);
        
        foreach ($settings as $element => $data) {
            TemplateSetting::updateOrCreate(
                [
                    'category_id' => $category->id,
                    'element' => $element
                ],
                [
                    'y_position' => $data['y'] ?? null,
                    'font_size' => $data['fontSize'] ?? null
                ]
            );
        }

        return response()->json(['success' => true]);
    }
}
