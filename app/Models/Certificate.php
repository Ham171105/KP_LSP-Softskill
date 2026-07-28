<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'certificate_number',
        'sequence_number',
        'global_sequence_number',
        'registration_number',
        'blanko_number',
        'participant_name',
        'gender',
        'participant_email',
        'issue_date',
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
