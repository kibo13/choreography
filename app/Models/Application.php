<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'num',
        'member_id',
        'group_id',
        'worker_id',
        'topic',
        'desc',
        'files',
        'note',
        'status',
    ];

    protected $casts = [
        'files' => 'array',
    ];
}
