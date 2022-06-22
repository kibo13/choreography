<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pass extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'year',
        'month',
        'is_active',
        'member_id',
        'group_id',
        'worker_id',
        'from',
        'till',
        'cost',
        'lessons',
        'status',
        'pay_date',
        'pay_file',
        'pay_note',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }
}
