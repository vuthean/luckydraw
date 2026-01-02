<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SMSLog extends Model
{
    use HasFactory;

    protected $fillable =[
        'customer_name',
        'customer_cif',
        'customer_account',
        'customer_phone',
        'sms_from',
        'sms_to',
        'sms_text',
        'sms_gateway',
        'send_date',
        'send_for_spin_date',
        'response',
        'description',
        'send_via',
        'status'
    ];
    protected $casts =[
        'send_date'          => 'date',
        'send_for_spin_date' => 'date',
    ];
}