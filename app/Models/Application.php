<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'pass_id',
        'num',
        'member_id',
        'group_id',
        'worker_id',
        'topic',
        'desc',
        'files',
        'note',
        'status',
        'voucher',
    ];

    protected $casts = [
        'files' => 'array',
    ];

    public function pass()
    {
        return $this->belongsTo(Pass::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
