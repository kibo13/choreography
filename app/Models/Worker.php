<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'last_name',
        'first_name',
        'middle_name',
        'position',
        'birthday',
        'age',
        'phone',
        'email',
        'address',
    ];

    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function specialties()
    {
        return $this->belongsToMany(Specialty::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($worker) {
            $worker->user()->delete();
        });
    }
}
