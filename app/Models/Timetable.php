<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'group_id',
        'from',
        'till',
        'worker_id',
        'room_id',
        'is_replace',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public $timestamps  = false;
}
