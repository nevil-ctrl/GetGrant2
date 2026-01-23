<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'university_id',
        'description',
        'image',
        'field_of_study',
        'is_top',
        'career_info',
        'is_active',
    ];

    protected $casts = [
        'is_top' => 'boolean',
        'is_active' => 'boolean',
        'career_info' => 'array',
    ];

    public function university()
    {
        return $this->belongsTo(University::class);
    }
}
