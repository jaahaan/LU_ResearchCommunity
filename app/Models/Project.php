<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'project_name',
        'project_type',
        'start_date',
        'end_date',
        'project_url',
        'project_description',
        'ongoing',
    ];
}
