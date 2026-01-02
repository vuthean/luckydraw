<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FailedLogOperation extends Model
{
    use HasFactory;

    protected $fillable =['activity','message','payload'];
    protected $casts =[
        'payload' => 'array',
    ];
}