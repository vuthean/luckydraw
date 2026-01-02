<?php

namespace App\Services;

use App\Enums\SMSStatus;
use App\Models\FailedLogOperation;
use App\Models\SMSLog;
use App\Traits\LuckyDrawDate;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class SMSService
{
    use LuckyDrawDate;

    public function send($customerName, $customerCif, $customerAccount, $phone, $message)
    {
        try {
            $gwFrom        = 'Prince-Bank';
            $gwTo          = $phone;
            $gwText        = $message;
            $spinDate      = $this->getLuckyDrawDate();

            $apiUrl = env('API_ORACLE_HOST');
            $result = Http::post("{$apiUrl}/api/sendsms", [
                'phonenumber' => $phone,
                'countrycode' => '855',
                'content'     => $gwText,
                'sendfrom'    => 'Lucky Draw',
            ]);

            $strResult = strtoupper(str_replace(' ', '', str_replace('"', '', $result)));
            if ($strResult === "SUCCESSSEND") {
                SMSLog::create([
                    'customer_name'      => $customerName,
                    'customer_cif'       => $customerCif,
                    'customer_account'   => $customerAccount,
                    'customer_phone'     => $phone,
                    'sms_from'           => $gwFrom,
                    'sms_to'             => $gwTo,
                    'sms_text'           => $gwText,
                    'sms_gateway'        => "{$apiUrl}/api/sendsms",
                    'send_date'          => Carbon::now(),
                    'send_for_spin_date' => $spinDate,
                    'response'           => $result,
                    'description'        => $result,
                    'send_via'           => 'Lucky Draw',
                    'status'             => SMSStatus::Success
                ]);
                return ['message'=>SMSStatus::Success];
            }

            /** when failed */
            SMSLog::create([
                'customer_name'      => $customerName,
                'customer_cif'       => $customerCif,
                'customer_account'   => $customerAccount,
                'customer_phone'     => $phone,
                'sms_from'           => $gwFrom,
                'sms_to'             => $gwTo,
                'sms_text'           => $gwText,
                'sms_gateway'        => "{$apiUrl}/api/sendsms",
                'send_date'          => Carbon::now(),
                'send_for_spin_date' => $spinDate,
                'response'           => $result,
                'description'        => $result,
                'send_via'           => 'Lucky Draw',
                'status'             => SMSStatus::Failed
            ]);
            return ['message'=>SMSStatus::Failed];
        } catch (\Exception $e) {
            FailedLogOperation::create([
                'activity' => "Cannot send SMS for phone number {$phone} whit conent : {$gwText}",
                'message'  => $e->getMessage(),
                'payload'  => [
                            'customer_name'      => $customerName,
                            'customer_cif'       => $customerCif,
                            'customer_account'   => $customerAccount,
                            'sms_from'           => $gwFrom,
                            'sms_to'             => $gwTo,
                            'sms_text'           => $gwText,
                            ]
            ]);
            return ['message'=>SMSStatus::Failed];
        }
    }
}
