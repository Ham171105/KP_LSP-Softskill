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
        
        $allCategories = \App\Models\Category::all();

        foreach ($request->settings as $elementId => $data) {
            foreach ($allCategories as $cat) {
                TemplateSetting::updateOrCreate(
                    [
                        'category_id' => $cat->id,
                        'element' => $elementId
                    ],
                    [
                        'x_position' => $data['x'] ?? null,
                        'y_position' => $data['y'] ?? null,
                        'font_size' => $data['fontSize'] ?? null,
                        'font_family' => $data['fontFamily'] ?? null,
                        'is_bold' => $data['isBold'] ?? false,
                        'is_italic' => $data['isItalic'] ?? false,
                        'custom_text' => $data['custom_text'] ?? null
                    ]
                );
            }
        }

        return response()->json(['success' => true]);
    }
}
