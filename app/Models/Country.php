<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    // Разрешенные для массового присваивания поля
    protected $fillable = [
        'name',
        'code',
        'flag',
        'description',
        'is_active',
        'selling_points', // если храните как JSON
    ];

    // Если selling_points хранится как JSON
    protected $casts = [
        'is_active' => 'boolean',
        'selling_points' => 'array',
    ];

    public function universities()
    {
        return $this->hasMany(University::class);
    }
}
