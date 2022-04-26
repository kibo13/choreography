<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sign',
        'note'
    ];

    public function groups()
    {
        return $this->hasMany(Group::class);
    }
}
