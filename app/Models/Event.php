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
        'group_id',
        'worker_id',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }

    public function members()
    {
        return $this->belongsToMany(Member::class);
    }
}
