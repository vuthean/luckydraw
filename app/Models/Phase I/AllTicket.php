<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllTicket extends Model
{
    use HasFactory;
    protected $table = 'all_ticket_view';
    protected $fillable = [
        'customer_CIF',
        'customer_name',
        'ticket_number',
        'ticket_id',
        'created_at',
        'users_id',
        'name'
    ];
}
