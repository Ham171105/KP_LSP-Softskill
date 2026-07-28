<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'element',
        'x_position',
        'y_position',
        'font_size',
        'font_family',
        'is_bold',
        'is_italic',
        'custom_text'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
