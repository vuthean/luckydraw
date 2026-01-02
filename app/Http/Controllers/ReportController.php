<?php

namespace App\Http\Controllers;

use App\Enums\WinType;
use App\Models\Winner;
use App\Traits\MasterUser;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\History;

class ReportController extends Controller
{
    use MasterUser;
    
    public function reportWinnerMotorPrize()
    {
        $winners = Winner::join('customers', 'customers.id', '=', 'winners.customer_id')
                    ->select('winners.*', 'customers.ticket_number as ticket_number')
                    ->where('winners.win_type', WinType::MotorBikePrize)
                    ->orderBy('win_at', 'DESC')
                    ->get();
        $isMaster = $this->isMasterUser();
        return view('reports.winner_motor_prize', compact('winners','isMaster'));
    }

    public function reportWinnerCashPrize()
    {
        $winners = Winner::join('customers', 'customers.id', '=', 'winners.customer_id')
                    ->select('winners.*', 'customers.ticket_number as ticket_number')
                    ->where('winners.win_type', WinType::CashPrize)
                    ->orderBy('win_at', 'DESC')
                    ->get();
        $isMaster = $this->isMasterUser();
        return view('reports.winner_cash_prize', compact('winners','isMaster'));
    }

    public function reportWinnerParasolPrize()
    {
        $winners = Winner::join('customers', 'customers.id', '=', 'winners.customer_id')
                    ->select('winners.*', 'customers.ticket_number as ticket_number')
                    ->where('winners.win_type', WinType::ParasolPrize)
                    ->orderBy('win_at', 'DESC')
                    ->get();
        $isMaster = $this->isMasterUser();
        return view('reports.winner_parasol_prize', compact('winners','isMaster'));
    }

    public function reportWinnerWaterBottlePrize()
    {
        $winners = Winner::join('customers', 'customers.id', '=', 'winners.customer_id')
                    ->select('winners.*', 'customers.ticket_number as ticket_number')
                    ->where('winners.win_type', WinType::WaterBottlePrize)
                    ->orderBy('win_at', 'DESC')
                    ->get();
        $isMaster = $this->isMasterUser();
        return view('reports.winner_water_bottle_prize', compact('winners','isMaster'));
    }

    public function reportWinnerGrandPrize()
    {
        $winners = Winner::join('customers', 'customers.id', '=', 'winners.customer_id')
                    ->select('winners.*', 'customers.ticket_number as ticket_number')
                    ->where('winners.win_type', WinType::MotorBikePrize)
                    ->orderBy('win_at', 'DESC')
                    ->get();
        $isMaster = $this->isMasterUser();
        return view('reports.winner_grand_prize', compact('winners','isMaster'));
    }

    public function reportWinnerHistoryPrize()
    {
        try {
    
            $winners = History::select(
                        'customer_cif_number',
                        'customer_account_number',
                        'customer_name',
                        'customer_phone',
                        'ticket_number as ticket_number',
                        'win_at',
                        'prize_name',
                    )
                    ->get();
            $isMaster = $this->isMasterUser();
            return view('history', compact('winners', 'isMaster'));
        } catch (\Throwable $th) {
           Log::error($th);
           throw $th;
        }
        
    }
}
