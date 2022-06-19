<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rep extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_rep',
        'first_name',
        'last_name',
        'middle_name',
        'doc_id',
        'doc_num',
        'doc_date',
        'doc_file',
        'doc_note',
        'app_file',
        'app_note',
        'agree_file',
        'agree_note',
        'phone',
        'email',
        'address',
        'note',
    ];

    public function members()
    {
        return $this->hasMany(Member::class);
    }

    public function doc()
    {
        return $this->belongsTo(Doc::class);
    }
}
