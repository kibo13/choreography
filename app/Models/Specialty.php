<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sign',
        'note'
    ];

    public function workers()
    {
        return $this->belongsToMany(Worker::class);
    }
}
