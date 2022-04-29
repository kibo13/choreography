<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'specialty_id',
        'is_paid',
        'note',
    ];

    public function specialty()
    {
        return $this->belongsTo(Specialty::class);
    }

    public function groups()
    {
        return $this->hasMany(Group::class);
    }
}
