<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pass extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'group_id',
        'worker_id',
        'from',
        'till',
        'cost',
        'lessons',
        'status',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }
}
