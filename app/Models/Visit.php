<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'timetable_id',
        'status',
        'reason',
        'file',
        'note',
    ];

    public $timestamps  = false;
}
