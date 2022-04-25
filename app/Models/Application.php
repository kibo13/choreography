<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'num',
        'user_id',
        'topic',
        'desc',
        'file',
        'note',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
