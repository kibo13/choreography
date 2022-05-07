<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'group_id',
        'form_study',
        'first_name',
        'last_name',
        'middle_name',
        'doc_id',
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

    public function doc()
    {
        return $this->belongsTo(Doc::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

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
