<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transactionhistory extends Model
{
    use HasFactory;
    protected $table = 'transactionhistory';
    protected $fillable = [
        'ticket_number',
        'ticket_date',
        'ticket_customerCIF',
        'ticket_customerAcctNo',
        'ticket_invalidAt'
    ];
}
