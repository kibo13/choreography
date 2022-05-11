<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'name',
        'from',
        'till',
        'place',
    ];

    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }
}
