<?php

namespace App\Models;

use App\Traits\Blamable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LuckyPrize extends Model
{
    use HasFactory, Blamable;

    protected $fillable = [
        'prize',
        'description',
        'file_url'
    ];
}