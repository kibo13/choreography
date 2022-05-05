<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_id',
        'category_id',
        'basic_seats',
        'extra_seats',
        'age_from',
        'age_till',
        'price',
        'lessons',
    ];

    public function title()
    {
        return $this->belongsTo(Title::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function workers()
    {
        return $this->belongsToMany(Worker::class);
    }

    public function members()
    {
        return $this->hasMany(Member::class);
    }
}
