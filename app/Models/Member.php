<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'rep_id',
        'group_id',
        'form_study',
        'first_name',
        'last_name',
        'middle_name',
        'birthday',
        'age',
        'phone',
        'email',
        'master',

        'discount_id',
        'discount_doc',
        'discount_note',
        'doc_id',
        'doc_num',
        'doc_date',
        'doc_file',
        'doc_note',
        'app_file',
        'app_note',
        'consent_file',
        'consent_note',
        'address_doc',
        'address_note',
        'address_fact',
        'activity',
    ];

    public function doc()
    {
        return $this->belongsTo(Doc::class);
    }

    public function rep()
    {
        return $this->belongsTo(Rep::class);
    }

    public function passes()
    {
        return $this->hasMany(Pass::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class);
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
