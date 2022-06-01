<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'from',
        'till',
        'worker_id',
        'room_id',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public $timestamps  = false;
}
