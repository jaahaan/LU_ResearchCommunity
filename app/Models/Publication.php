<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'publication_title',
        'publication_description',
        'publication_link',
        'ongoing',
        'starting_date',
        'ending_date',
    ];
}
