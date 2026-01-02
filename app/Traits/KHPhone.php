<?php

namespace App\Traits;

trait KHPhone
{
    public function formatToKHPhone($phoneString)
    {
        if(env('APP_ENV') == 'local' || env('APP_ENV') == 'UAT' || env('APP_ENV') == 'SIT')
        {
            return "+85510912908";
        }

        $formatPhone = ltrim($phoneString->CUSTOMER_PHONE, '0');
        $khPhone     = "+855{$formatPhone}";

        return  $khPhone;
    }
}