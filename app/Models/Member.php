<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'middle_name',
        'doc_type',
        'doc_num',
        'doc_date',
        'birthday',
        'age',
        'address_doc',
        'address_note',
        'address_fact',
        'activity',
        'phone',
        'email',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($member) {
            $member->user()->delete();
        });
    }
}
