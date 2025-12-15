<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class University extends Model
{
    use HasFactory;

    // Поля, разрешенные для массового присваивания
    protected $fillable = [
        'country_id',
        'name',
        'description',
        'logo',
        'website',
        'level',
        'cost_min',
        'cost_max',
        'requirements',
        'deadlines',
        'is_active',
    ];

    // Поля, которые должны быть автоматически приведены к определенным типам
    protected $casts = [
        'is_active' => 'boolean',
        // Обрабатываем эти поля как JSON/массив
        'requirements' => 'array',
        'deadlines' => 'array',
        'cost_min' => 'integer',
        'cost_max' => 'integer',
    ];

    /**
     * Связь: Университет принадлежит одной Стране.
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Программы университета.
     */
    public function programs()
    {
        return $this->hasMany(Program::class);
    }
}
