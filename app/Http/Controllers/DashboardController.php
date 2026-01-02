<?php

namespace App\Http\Controllers;

use App\Models\Winner;
use App\Traits\LuckyDrawDate;
use App\Traits\MasterUser;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    use MasterUser;
    use LuckyDrawDate;

    public function index()
    {
        try {
            $transactionDate  = $this->getLuckyDrawDate();
            $transactionMonth = $transactionDate->month;
    
            $winners = Winner::join('customers', 'customers.id', '=', 'winners.customer_id')
                    ->whereMonth('winners.win_at', $transactionMonth)
                    ->select(
                        'customers.cif_number',
                        'customers.account_number',
                        'customers.name',
                        'customers.phone_number',
                        'customers.ticket_number',
                        'winners.win_at',
                        'prize_name',
                    )
                    ->get();
            $isMaster = $this->isMasterUser();
            return view('dashboard', compact('winners', 'isMaster'));
        } catch (\Throwable $th) {
           Log::error($th);
           throw $th;
        }
        
    }
}
