<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    use HasFactory;

    protected $fillable = [
        'num',
        'date_reg',
        'date_doc',
        'name_doc',
        'group_id',
        'orgkomitet_id',
        'note',
    ];

    public function orgkomitet()
    {
        return $this->belongsTo(Orgkomitet::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function totalSeats()
    {
        return $this->group->basic_seats + $this->group->extra_seats;
    }
}

