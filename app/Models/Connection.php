<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{
    use HasFactory;
    protected $fillable = [
        'from_id',
        'to_id',
        'last_msg'
    ];
    public function user1(){
        return $this->belongsTo(User::class, 'from_id');
    }

    public function user2(){
        return $this->belongsTo(User::class, 'to_id');
    }
}
