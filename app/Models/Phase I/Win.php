<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Win extends Model
{
    use HasFactory;
    protected $table = 'win';
    protected $fillable = [
        'prize_id',
        'user_id',
        'ticket_id',
        'win_delYN'
    ];
}
