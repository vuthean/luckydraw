<?php

namespace App\Models;

use App\Traits\Blamable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    use Blamable;

    protected $fillable = [
        'customer_id',
        'customer_name',
        'customer_cif_number',
        'customer_account_number',
        'customer_phone',
        'number',
        'win_at',
        'win_type',
        'generated_at',
        'spind_monthly_prize_at',
        'spind_grand_prize_at'
    ];
    protected $casts =[
        'generated_at'            => 'date',
        'win_at'                  => 'date',
        'spind_monthly_prize_at'  => 'date',
        'spind_grand_prize_at'    => 'date',
    ];
}
