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
        'method_id',
        'note',
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function method()
    {
        return $this->belongsTo(Method::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public $timestamps  = false;
}
