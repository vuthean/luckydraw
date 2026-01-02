<?php

namespace App\Console\Commands;

use App\Models\Ticket;
use App\Services\SMSService;
use App\Traits\LuckyDrawDate;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class sendSMSMonthlyPrize extends Command
{
    use LuckyDrawDate;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:send-monthly-prize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send all customer ticket for monthly prize.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            /** log schedule to send sms */
            $currentDate = Carbon::now();
            Log::channel('sms')->info("Schedule run to send SMS on date: {$currentDate} is working fine");

            $luckyDrawDate = $this->getLuckyDrawDate();
            $month         = $luckyDrawDate->month;

            /** get all ticket for current month */
            $tickets = Ticket::whereMonth('generated_at', $month)
                    ->whereNull('spind_monthly_prize_at')
                    ->whereNull('spind_grand_prize_at')
                    ->whereNull('win_at')
                    ->get();
            if (collect($tickets)->isEmpty()) {
                Log::channel('sms')->info("Cannot send SMS since we cannot find any customer tickets on month :{$month}");
                return false;
            }

            /** get all customer that has ticket */
            $customerIds = collect($tickets)->pluck('customer_id')->unique()->all();
            $totalCustomerSendSMS = 0;
            foreach ($customerIds as $customerId) {
                $customerTickets       = collect($tickets)->where('customer_id', $customerId)->pluck('number');
                $customerTicketNumbers = collect($customerTickets)->implode(',');
                $totalCustomerTicket   = collect($customerTickets)->count();

                /** message template */
                $setting        = config('setting');
                $messageContent = $setting['message_content'];
                $content        = __($messageContent, [
                                    'tocketAmount' => $totalCustomerTicket,
                                    'tiketNumbers' => $customerTicketNumbers
                                ]);

                /** find customer information */
                $customer = (object)collect($tickets)->firstWhere('customer_id', $customerId);

                /** send message service */
                $smsService  = new SMSService();
                $smsService->send(
                    $customerName    = $customer->customer_name,
                    $customerCif     = $customer->customer_cif_number,
                    $customerAccount = $customer->customer_account_number,
                    $phone           = $customer->customer_phone,
                    $message         = $content
                );

                $totalCustomerSendSMS += 1 ;
            }
            Log::channel('sms')->info("Total customer to send SMS = {$totalCustomerSendSMS}");
        } catch (Exception $e) {
            Log::channel('sms')->info($e);
        }
    }
}
