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
        'workload',
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

    public function loads()
    {
        return $this->hasMany(Load::class);
    }

    public function getTotalHours()
    {
        $total = 0;

        foreach ($this->loads as $load) {
            $total += $load->duration;
        }

        return $total;
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
