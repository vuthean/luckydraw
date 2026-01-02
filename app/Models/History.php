<?php

namespace App\Models;

use App\Traits\Blamable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\WinType;

class History extends Model
{
    //
    use HasFactory;
    use Blamable;

    protected $table = 'histories';
    protected $fillable = [
        'customer_id',
        'customer_name',
        'customer_cif_number',
        'customer_account_number',
        'customer_phone',
        'ticket_id',
        'lucky_prize_id',
        'prize_name',
        'win_type',
        'win_at',
        'ticket_number'
    ];

    protected $casts = ['win_at' => 'date','win_type' => WinType::class,];
    
}
