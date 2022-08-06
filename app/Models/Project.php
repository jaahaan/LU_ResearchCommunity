<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'project_title',
        'project_description',
        'project_link',
        'ongoing',
        'starting_date',
        'ending_date',
    ];
}
