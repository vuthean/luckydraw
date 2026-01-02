<?php

namespace App\Http\Controllers;

use App\Models\AllTicket;
use App\Models\LuckyPrize;
use App\Models\Customer;
use App\Models\Prize;
use App\Models\Ticket;
use App\Traits\LuckyDrawDate;
use App\Traits\SpinDate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SpinController extends Controller
{
    use LuckyDrawDate;

    public function oldSpin()
    {
        $allTickets = Ticket::get();

        $prizes = LuckyPrize::first();
        return view('spin', compact('allTickets', 'prizes'));
    }

    public function getTicket()
    {
        if (Auth::user()->role_id == 2) {
            $random = AllTicket::where('customer_winStatus', false)
                ->inRandomOrder()
                ->first();

            return response()->json($random);
        }
        return redirect()->back();
    }

    //====================== phase 2 ===============
    public function spinMonthlyPrize()
    {
        $drawNumClass = [
            'one','two','three','four','five'
        ];
        return view('spins.motor_prize',compact('drawNumClass'));
    }

    public function spinCashPrize()
    {
        $drawNumClass = [
            'one','two','three','four','five'
        ];
        return view('spins.cash_prize',compact('drawNumClass'));
    }
    public function spinParasolPrize()
    {
        $drawNumClass = [
            'one','two','three','four','five'
        ];
        return view('spins.parasol_prize',compact('drawNumClass'));
    }

    public function spinWaterBottlePrize()
    {
        $drawNumClass = [
            'one','two','three','four','five'
        ];
        return view('spins.water_bottle_prize',compact('drawNumClass'));
    }

    public function spinGrandPrize()
    {
        return view('spins.grand_prize');
    }

    public function getRandomTicketForMonthlyPrize()
    {
        $luckyDrawMonth = $this->getLuckyDrawDate()->month;

        /**New condition get data from Customer*/
        $random = $this->getLuckyRandom();
        return response()->json($random);
    }

    public function getRandomTicketForCashPrize()
    {
        $luckyDrawMonth = $this->getLuckyDrawDate()->month;

        /**New condition get data from Customer*/
        $random = $this->getLuckyRandom();
        return response()->json($random);
    }

    public function getRandomTicketForParasolPrize()
    {
        /**New condition get data from Customer*/
        $random = $this->getLuckyRandom();
        return response()->json($random);
    }

    public function getRandomTicketForWaterBottlePrize()
    {
        /**New condition get data from Customer*/
        $random = $this->getLuckyRandom();
        return response()->json($random);
    }

    public function getRandomTicketForGrandPrize()
    {
        $random = Ticket::whereNotNull('spind_monthly_prize_at')
                        ->whereNull('win_at')
                        ->whereNull('spind_grand_prize_at')
                        ->inRandomOrder()
                        ->first();
        return response()->json($random);
    }
    private function getLuckyRandom(){
        $random = Customer::where('status','ACTIVE')
                        ->inRandomOrder()
                        ->first();
        return $random;
    }
}
