<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ExportDataService extends Controller
{
    public function export()
    {
        $testConnection = DB::connection('oracle')->table('P1FCHPRFM.stvw_customer_lucky_draw')->first();
        dd($testConnection);
        $generate_EOD = DB::connection('mysql_CBS')
            ->table('stvw_cust_dtls_lucky_draw1')
            ->get();

        if (!empty($generate_EOD)) {
            foreach ($generate_EOD as $key => $value) {
                Customer::updateOrCreate(
                    [
                        'customer_CIF' => $value->CIF_NUMBER,
                        'customer_accountNo' => $value->ACCOUNT_NUMBER
                    ],
                    [
                        'customer_CIF' => $value->CIF_NUMBER,
                        'customer_accountNo' => $value->ACCOUNT_NUMBER,
                        'customer_name' => $value->CUSTOMER_NAME,
                        'customer_TEL' => $value->CUSTOMER_PHONE,
                        'customer_EODBalance' => $value->EOD_BALANCE,
                        'customer_accountCat' => $value->ACCOUNT_CATEGORY,
                        'customer_toKYCAt' => $value->TO_KYC_DATE
                    ]
                );
            }

            // get customers with EOD >= 20 and have not been coverted to full KYC
            $EOD_cutomer = Customer::whereRaw('(customer_EODBalance >= 20) and (isnull(customer_toKYCAt))')
                ->get();

            // generate ONE ticket for every records from $EOD_cutomer
            foreach ($EOD_cutomer as $key => $value) {
                $cust_info = [
                    'customer_CIF' => $value->customer_CIF,
                    'customer_accountNo' => $value->customer_accountNo
                ];
                $this->createTicket($cust_info);
            }

            // we generate every 1st of next month
            // get customers that have changed to full KYC in the previous month
            $KYC_Customer = Customer::whereRaw('month(customer_toKYCAt) = month(now())-1')
                ->get();

            // generate THREE tickets for every records from $KYC_Customer
            foreach ($KYC_Customer as $key => $value) {
                for ($i = 0; $i < 3; $i++) {
                    $cust_info = [
                        'customer_CIF' => $value->customer_CIF,
                        'customer_accountNo' => $value->customer_accountNo
                    ];
                    $this->createTicket($cust_info);
                }
            }
        }

        // get customers that have not been coverted to full KYC
        $TRAN_Customer = Customer::whereRaw('isnull(customer_toKYCAt)')
            ->get();

        foreach ($TRAN_Customer as $key => $value) {

            // get total transactions of each account from $TRAN_Customer
            $generate_Transaction = DB::connection('mysql_CBS')
                ->table('stvw_cust_dtls_lucky_draw2')

                // *** need to add condition after get to know tran code of Bill Payment, PrincePay, Transfer, or Phone Top Up
                ->whereRaw('(month(TRN_DT) = month(now())-1) and (CUST_AC_NO = ' . $value->customer_accountNo . ')')
                ->count();

            // create TWO tickets every 5 transactions for each customer from $TRAN_Customer in their previous month
            $total_ticket = floor($generate_Transaction / 5);
            for ($i = 0; $i < $total_ticket; $i++) {
                for ($j = 0; $j < 2; $j++) {
                    $cust_info = [
                        'customer_CIF' => $value->customer_CIF,
                        'customer_accountNo' => $value->customer_accountNo
                    ];
                    $this->createTicket($cust_info);
                }
            }
        }
    }

    private function createTicket($cust_info)
    {
        Ticket::create(
            [
                'ticket_number' => str_pad((int)Ticket::max('id') + 1, 9, '0', STR_PAD_LEFT),
                'ticket_date' => Carbon::now(),
                'ticket_customerCIF' => $cust_info['customer_CIF'],
                'ticket_customerAcctNo' => $cust_info['customer_accountNo'],
                'ticket_invalidAt' => null
            ]
        );
    }

    public function sendSMS()
    {
        $SMS_Content_p1 = 'We would like to inform you that you have ';
        $ticket_Amt = 0;
        $SMS_Content_p2 = ' tickets qualify for this month lucky draw. Your Ticket No. are ';
        $ticket_list = ''; // ####, ####, ####.
        $SMS_Content_p3 = ' The lucky draw will be done remotely through Prince Bank Plc. official Facebook page on 6th this month.
For more information, please contact 1800 20 8888.';

        // get customers that have not been coverted to full KYC
        $SMS_customer = Customer::whereRaw('(isnull(customer_toKYCAt)) or (month(customer_toKYCAt) = month(now())-1)')
            ->get();

        foreach ($SMS_customer as $key => $value) {
            $ticket_Amt = Ticket::whereNull('ticket_invalidAt')
                ->where('ticket_customerAcctNo', $value->customer_accountNo)
                ->count();

            if ($ticket_Amt != 0) {
                $tickets = Ticket::whereNull('ticket_invalidAt')
                ->where('ticket_customerAcctNo', $value->customer_accountNo)
                    ->get();

                $ticket_list = '';
                foreach ($tickets as $key => $ticket) {
                    $ticket_list = $ticket_list . $ticket->ticket_number . ', ';
                }
                $ticket_list = rtrim($ticket_list, ', ');

                $whole_SMS_content = $SMS_Content_p1 . $ticket_Amt . $SMS_Content_p2 . $ticket_list . '.' . $SMS_Content_p3;

                $form_param = [
                    'phonenumber' => $value->customer_TEL,
                    'countrycode' => '855',          // fixed for cambodia region first
                    'content' => $whole_SMS_content,
                    'sendfrom' => 'Lucky Draw',
                ];

                $result = Http::post('http://api.cbs.princeplc.com.kh/api/sendsms', $form_param);
            }
        }
    }
}
