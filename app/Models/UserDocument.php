<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'application_id',
        'type',
        'file_path',
        'status',
        'comment',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function document()
    {
        return $this->belongsTo(Document::class, 'type', 'type');
    }
}
