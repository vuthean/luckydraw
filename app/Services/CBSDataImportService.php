<?php

namespace App\Services;

use App\Models\CBSTransaction;
use App\Models\Customer;
use App\Models\FailedLogOperation;
use App\Traits\KHPhone;
use App\Traits\LuckyDrawDate;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CBSDataImportService
{
    use KHPhone;
    use LuckyDrawDate;

    public function importCustomer()
    {
        try {
            $apiUrl = env('API_ORACLE_HOST');

            /** get customer list from cbs */
            $cbsCustomers     = Http::withOptions(['verify' => false])->get("{$apiUrl}/api/customers/customer-list");
            $customerResponse = json_decode((string) $cbsCustomers->getBody(), true);
            if ($customerResponse["data"]["response_header"]["status"] == 'Failure') {
                FailedLogOperation::create([
                    'activity' => 'connect to cbs for getting customer information.',
                    'message'  => 'Failure',
                    'payload'  => $cbsCustomers
                ]);

                return [];
            }
            /** process syncing data */
            $customers    = $customerResponse["data"]["response_body"];
            DB::transaction(function () use ($customers) {
                $totalCustomer = 0;
                foreach ($customers as $customer) {
                    $cbsCustomer = (object)$customer;

                    /** import customer */
                    Customer::updateOrCreate(
                        [
                        'cif_number'       => $cbsCustomer->cif_number,
                        'account_number'   => $cbsCustomer->account_number,
                    ],
                        [
                        'cif_number'       => $cbsCustomer->cif_number,
                        'account_number'   => $cbsCustomer->account_number,
                        'name'             => $cbsCustomer->customer_name,
                        'phone_number'     => $cbsCustomer->customer_phone,
                        'account_category' => $cbsCustomer->account_category,
                        'eod_balance'      => $cbsCustomer->eod_balance,
                        'to_kyc_at'        => $cbsCustomer->to_kyc_date,
                        'imported_at'      => Carbon::now()->subMonth()
                    ]
                    );
                    $totalCustomer +=1;
                }
                Log::channel('cbs_connection')->info("Total import customer = {$totalCustomer}");
            });


            /** get customer transaction from cbs */
            $transactionDate  = $this->getLuckyDrawDate();
            $transactionMonth = $transactionDate->month;

            $cbsTransactions     = Http::withOptions(['verify' => false])->timeout(180)->get("{$apiUrl}/api/customers/customer-transaction?transactionMonth={$transactionMonth}");
            $transactionResponse = json_decode((string) $cbsTransactions->getBody(), true);
           
            if ($transactionResponse["data"]["response_header"]["status"] == 'Failure') {
                FailedLogOperation::create([
                    'activity' => 'connect to cbs for getting customer information.',
                    'message'  => 'Failure',
                    'payload'  => collect($transactionResponse)->toArray()
                ]);

                /** destroy all old transaction */
                CBSTransaction::whereNotNull('id')->delete();
            } else {
                /** process syncing data */
                $transactions = $transactionResponse["data"]["response_body"];
                DB::transaction(function () use ($transactions) {

                    /** destroy all old transaction */
                    CBSTransaction::whereNotNull('id')->delete();

                    $totalTransaction = 0;

                    /** import customer transaction */
                    foreach ($transactions as $cbstransaction) {
                        $transaction = (object)$cbstransaction;
                        $transaction = CBSTransaction::create([
                            'transaction_code'        => $transaction->trn_code,
                            'transaction_description' => $transaction->trn_desc,
                            'transaction_date'        => $transaction->trn_dt,
                            'customer_account_number' => $transaction->cust_ac_no,
                            'imported_at'             => Carbon::now()->subMonth()
                        ]);
                        $totalTransaction +=1;

                        Log::channel('cbs_connection')->info("Total import customer transaction = {$totalTransaction}");
                    }
                });
            }

            return '';//$customers;
        } catch (\Exception $e) {
            FailedLogOperation::create([
                'activity' => 'connect to cbs for getting customer information.',
                'message'  => $e
            ]);

            return [];
        }
    }
}
