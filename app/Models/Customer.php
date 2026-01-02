<?php

namespace App\Models;

use App\Traits\Blamable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    use Blamable;

    protected $fillable = [
        'cif_number',
        'account_number',
        'name',
        'phone_number',
        'account_category',
        'eod_balance',
        'to_kyc_at',
        'imported_at',
        'status',
        'cif_location',
        'list_number_of_ticket',
        'win_at',
        'win_type',
        'status',
        'ticket_number'
    ];

    protected $casts =[
        'eod_balance' => 'double',
        'to_kyc_at'   => 'date',
        'imported_at' => 'date'
    ];

    public function scopeJoinTicket($query)
    {
        return $query->join('tickets', 'tickets.customer_id', '=', 'customers.id');
    }
}
