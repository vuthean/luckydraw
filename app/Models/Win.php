<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Win extends Model
{
    use HasFactory;
    protected $table = 'win';
    protected $fillable = [
        'id',
        'win_prizeID',
        'win_ticketID',
        'win_delAt'
    ];
}
