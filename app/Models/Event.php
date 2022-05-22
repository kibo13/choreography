<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'orgkomitet_id',
        'name',
        'from',
        'till',
        'place',
        'group_id',
        'worker_id',
        'description',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function orgkomitet()
    {
        return $this->belongsTo(Orgkomitet::class);
    }

    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }

    public function achievement()
    {
        return $this->hasOne(Achievement::class);
    }

    public function members()
    {
        return $this->belongsToMany(Member::class);
    }
}
