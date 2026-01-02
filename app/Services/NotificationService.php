<?php

namespace App\Services;

use App\Enums\SMSStatus;
use App\Models\FailedLogOperation;
use App\Models\SMSLog;
use App\Traits\LuckyDrawDate;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    use LuckyDrawDate;

    public function send($subject, $content, $customerName, $customerEmail)
    {
        try {
            $details = [
                'title' => ' Lucky Draw Ticket Eligibility Notification',
                'content' => $content,
                'name' => $customerName,
                'branch'=>'',
                'position'=>'',
                'comment'=>''
            ];
            $viewname = "emails.myTestMail";
            if (\App::environment('prd')) {
                \Mail::to('h.vuthean@princebank.com.kh')->cc('h.vuthean@princebank.com.kh')->send(new \App\Mail\MyTestMail($details, $subject, $viewname));
                // \Mail::to($checker)->cc($cc)->send(new \App\Mail\MyTestMail($details, $subject, $viewname));
            }
            if (\App::environment('local')) {
                \Mail::to($customerEmail)->cc('h.vuthean@princebank.com.kh')->send(new \App\Mail\MyTestMail($details, $subject, $viewname));
            }
            return "success";
        } catch (\Exception $e) {
            Log::channel('email_failed')->info([
                'sender'=>env('MAIL_FROM_ADDRESS'),
                'req_name'=>'',
                'receiver'=>'',
                'cc'=>''
            ]);
            Log::error($e);
            Log::channel('email_failed')->info($e);
            return "fail";
        }
    }
}
