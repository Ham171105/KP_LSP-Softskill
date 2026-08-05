<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\TemplateSetting;
use Illuminate\Http\Request;

class TemplateSettingController extends Controller
{
    public function store(Request $request, Category $category)
    {
        \Log::info('Template settings payload: ', $request->all());
        $settings = $request->input('settings', []);
        
        $allCategories = \App\Models\Category::all();

        foreach ($request->settings as $elementId => $data) {
            foreach ($allCategories as $cat) {
                if ($cat->id === $category->id) {
                    // For the current category, save everything including positions
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
                            'text_align' => $data['textAlign'] ?? null,
                            'color' => $data['color'] ?? null,
                            'is_underline' => $data['isUnderline'] ?? false,
                            'custom_text' => $data['custom_text'] ?? null
                        ]
                    );
                } else {
                    // For other categories, ONLY sync font styles (keep their own X/Y positions)
                    $existing = TemplateSetting::where('category_id', $cat->id)
                                               ->where('element', $elementId)
                                               ->first();
                    
                    TemplateSetting::updateOrCreate(
                        [
                            'category_id' => $cat->id,
                            'element' => $elementId
                        ],
                        [
                            // Preserve existing positions if they exist, otherwise fallback to null to keep default flow
                            'x_position' => $existing ? $existing->x_position : ($data['x'] ?? null),
                            'y_position' => $existing ? $existing->y_position : ($data['y'] ?? null),
                            'font_size' => $data['fontSize'] ?? null,
                            'font_family' => $data['fontFamily'] ?? null,
                            'is_bold' => $data['isBold'] ?? false,
                            'is_italic' => $data['isItalic'] ?? false,
                            'text_align' => $existing ? $existing->text_align : null,
                            'color' => $existing ? $existing->color : null,
                            'is_underline' => $existing ? $existing->is_underline : false,
                            'custom_text' => $existing ? $existing->custom_text : null
                        ]
                    );
                }
            }
        }

        return response()->json(['success' => true]);
    }
}
