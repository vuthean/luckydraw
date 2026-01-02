<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllWinner extends Model
{
    use HasFactory;
    protected $table = 'all_winner_view';
    protected $fillable = [
        'customer_CIF',
        'customer_name',
        'customer_TEL',
        'customer_winStatus',
        'created_at',
        'win_delYN',
        'ticket_number',
        'prize_Description'
    ];
}
