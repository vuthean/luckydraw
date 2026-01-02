<?php

namespace App\Models;

use App\Traits\Blamable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auditlog extends Model
{
    use HasFactory, Blamable;

    protected $fillable = [
        'user_id',
        'activity',
        'model_type',
        'model_id',
        'old_value',
        'new_value'
    ];
}