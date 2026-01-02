<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CBSTransaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'transaction_code',
        'transaction_description',
        'transaction_date',
        'customer_account_number',
        'imported_at'
    ];
    protected $casts =[
        'transaction_date'   => 'date',
        'imported_at'        => 'date'
    ];
}
