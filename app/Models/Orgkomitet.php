<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orgkomitet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'site',
        'from',
        'till',
        'note',
    ];
}
