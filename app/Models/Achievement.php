<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'num',
        'name',
        'event_id',
        'note',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
