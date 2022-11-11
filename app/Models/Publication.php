<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'publication_type',
        'publication_title',
        'publication_abstract',
        'author_id',
        'url',
        'start_date',
        'end_date',
    ];

    public function user(){
        return $this->belongsToMany('App\Models\User', 'authors');
    }
}
