<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diplom extends Model
{
    use HasFactory;

    protected $fillable = [
        'achievement_id',
        'member_id',
        'file',
        'note',
    ];
}
