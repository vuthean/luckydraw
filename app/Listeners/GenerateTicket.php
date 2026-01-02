<?php

namespace App\Listeners;

use App\Models\CBSTransaction;
use App\Models\Customer;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GenerateTicket
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $month = $event->month;

        DB::transaction(function () use ($month) {
            /** generate ticket for customer that has eod balance >= 20 */
            $this->generateTicketForEODFor($month);

            /** generate ticket for customer converted to full KYC */
            $this->generateTicketForFullKYC($month);

            /** generate ticket for bill payment transaction */
            $this->generateTicketForTransaction($month);
        });
    }

    private function generateTicketForEODFor($month)
    {
        /**
         * we generate all e-account in current month only.
         * if customer already converted to full KYC before current month
         * then we don't generate it
         * */
        $EODCustomers = Customer::whereMonth('imported_at', $month)
                        ->whereRaw('(to_kyc_at is null or MONTH(to_kyc_at) = ?)', [$month])
                        ->where('eod_balance', '>=', 20)
                        ->get();
        foreach ($EODCustomers as $customer) {
            $ticketNumber = $this->generateTicketNumber();
            Ticket::create([
                    'customer_id'             => $customer->id,
                    'customer_name'           => $customer->name,
                    'customer_cif_number'     => $customer->cif_number,
                    'customer_account_number' => $customer->account_number,
                    'customer_phone'          => $customer->phone_number,
                    'number'                  => $ticketNumber,
                    'generated_at'            => Carbon::now()->subMonth(),
                ]);
        }
    }

    private function generateTicketForFullKYC($month)
    {
        $customers   = Customer::whereMonth('to_kyc_at', $month)->get();
        $allowTicket = 3;

        /** generate only three ticket */
        foreach ($customers as $customer) {
            for ($i = 1; $i <= $allowTicket ; $i++) {
                $ticketNumber = $this->generateTicketNumber();
                Ticket::create([
                    'customer_id'             => $customer->id,
                    'customer_name'           => $customer->name,
                    'customer_cif_number'     => $customer->cif_number,
                    'customer_account_number' => $customer->account_number,
                    'customer_phone'          => $customer->phone_number,
                    'number'                  => $ticketNumber,
                    'generated_at'            => Carbon::now()->subMonth(),
                ]);
            }
        }
    }

    public function generateTicketForTransaction($month)
    {
        /** get all customer in current month */
        $customers = Customer::whereMonth('imported_at', $month)->get();
        foreach ($customers as $customer) {
            $ticketQuantity = 0;
            if ($customer->to_kyc_at) {
                $kycDate = Carbon::parse($customer->to_kyc_at)->format('Y-m-d');
                $tranQuantity = CBSTransaction::where('customer_account_number', $customer->account_number)
                                ->whereMonth('imported_at', $month)
                                ->whereDate('transaction_date', '<', $kycDate)
                                ->count();
                $ticketQuantity = bcdiv($tranQuantity, 5, 0);
            } else {
                $tranQuantity = CBSTransaction::where('customer_account_number', $customer->account_number)
                                ->whereMonth('imported_at', $month)
                                ->count();
                $ticketQuantity = bcdiv($tranQuantity, 5, 0);
            }

            /** one quantity need to generate two tickets */
            $totalTickets = bcmul($ticketQuantity, 2);

            /** make sure all ticket is not more than 20 */
            $existingTickets = Ticket::where('customer_id', $customer->id)->count();
            if ($existingTickets >= 20) {
                continue;
            }

            $ticketAllowen = bcsub(20, $existingTickets);
            if ($totalTickets > $ticketAllowen) {
                $totalTickets = $ticketAllowen;
            }

            /** save ticket for customer */
            if ($totalTickets > 0) {
                for ($i = 1; $i <= $totalTickets ; $i++) {
                    $ticketNumber = $this->generateTicketNumber();
                    Ticket::create([
                        'customer_id'             => $customer->id,
                        'customer_name'           => $customer->name,
                        'customer_cif_number'     => $customer->cif_number,
                        'customer_account_number' => $customer->account_number,
                        'customer_phone'          => $customer->phone_number,
                        'number'                  => $ticketNumber,
                        'generated_at'            => Carbon::now()->subMonth(),
                    ]);
                }
            }
        }
    }

    private function generateTicketNumber()
    {
        $latestTicketid = Ticket::max('id');
        $increaseOne    = (int)$latestTicketid + 1;
        $ticketNumber   = str_pad($increaseOne, 9, '0', STR_PAD_LEFT);

        return $ticketNumber;
    }
}
