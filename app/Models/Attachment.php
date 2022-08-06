<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;
    protected $fillable = [
        'post_id',
        'image',
        'pdf',
        'pptx',
        'xlsx',
        'docs',
    ];
}
