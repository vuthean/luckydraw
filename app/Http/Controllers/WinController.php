<?php

namespace App\Http\Controllers;

use App\Enums\WinType;
use Illuminate\Http\Request;
use App\Models\AllWinner;
use App\Models\Customer;
use App\Models\LuckyPrize;
use App\Models\Ticket;
use App\Models\Win;
use App\Models\Winner;
use App\Traits\LuckyDrawDate;
use App\Traits\MasterUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\NotificationService;

class WinController extends Controller
{
    use LuckyDrawDate;
    use MasterUser;

    public function index()
    {
        // get all winners record
        $allWinner = AllWinner::orderBy('created_at', 'asc')->get();

        $isMaster = $this->isMasterUser();
        return view('dashboard', compact('allWinner', 'isMaster'));
    }

    public function winnerSave(Request $request)
    {
        // dd($request);
        if (Auth::user()->role_id == 2) {
            $wins = new Win();
            $wins->prize_id = $request->prize_id;
            $wins->user_id = $request->users_id;
            $wins->ticket_id = $request->ticket_id;

            $wins->save();

            $update_Customer = ['customer_winStatus' => true];
            Customer::where('customer_CIF', $request->customer_CIF)->update($update_Customer);
        }
        return redirect()->back();
    }



    public function getWinner()
    {
        if (Auth::user()->role_id == 2) {
            $prize1_Winner = AllWinner::where('prize_Description', '5,000,000')
                ->orderBy('created_at', 'asc')
                ->limit(1)
                ->get();

            $prize2_Winner = AllWinner::where('prize_Description', '3,000,000')
                ->orderBy('created_at', 'asc')
                ->limit(1)
                ->get();

            $prize3_Winner = AllWinner::where('prize_Description', '1,000,000')
                ->orderBy('created_at', 'asc')
                ->limit(10)
                ->get();
            return response()->json([$prize1_Winner, $prize2_Winner, $prize3_Winner]);
        }
        return redirect()->back();
    }

    public function update()
    {
        if (Auth::user()->role_id == 2) {
            $update_Customer = ['customer_winStatus' => false];
            Customer::where('customer_winStatus', true)
            ->orwhereNull('customer_winStatus')
            ->update($update_Customer);

            $delete_Win = ['win_delYN' => true];
            Win::where('win_delYN', true)->orwhereNull('win_delYN')
            ->update($delete_Win);
        }
        return redirect()->back();
    }

    //====================== save winner ========================
    public function saveMonthlyPriceWinner($ticketId)
    {
        DB::transaction(function () use ($ticketId) {
            $spinDate = $this->getLuckyDrawDate();
            // $ticket = Ticket::firstWhere('id', $ticketId);
            $customer = Customer::firstWhere('id', $ticketId);
            /** check lucky prize */
            $prize = LuckyPrize::firstWhere('prize', 'Motor Bike');
            if (!$prize) {
                $prize = LuckyPrize::create([
                    'prize' => 'Motor Bike',
                    'description' => 'Motor Bike'
                ]);
            }

            /**save winner */
            Winner::create([
                    'customer_id'             => $customer->id,
                    'customer_name'           => $customer->name,
                    'customer_cif_number'     => $customer->cif_number,
                    'customer_account_number' => $customer->account_number,
                    'customer_phone'          => $customer->phone_number,
                    'ticket_number'           => $customer->ticket_number,
                    'lucky_prize_id'          => $prize->id,
                    'prize_name'              => $prize->prize,
                    'win_type'                => WinType::MotorBikePrize,
                    'win_at'                  => $spinDate,
                ]);

            /** update customer to win */
            $customer->update([
                    'win_at'                 => $spinDate,
                    'win_type'               => WinType::MotorBikePrize,
                ]);
            /** update customer current customer customer not to spin again */
            $spinMonth = $spinDate->month;
            Customer::where('cif_number', $customer->cif_number)->where('account_number',$customer->account_number)
                        ->update(['status' => 'INACTIVE']);
            /**Send Notification by mail */
            // $this->sendNotificationMontlyPrizeWinner($ticketId);

            /** find if that winner is the top 10 */
            $customer = Winner::where('win_type', WinType::MotorBikePrize)->whereMonth('win_at', $spinMonth)->count();
            // if ((int)$customer >= 10) {
            //     Ticket::whereMonth('generated_at', $spinDate->month)->update(['spind_monthly_prize_at' => $spinDate]);
            // }
        });

        return redirect()->back();
    }

    //====================== save winner cash ========================
    public function saveCashPriceWinner($ticketId)
    {
        DB::transaction(function () use ($ticketId) {
            $spinDate = $this->getLuckyDrawDate();
            $customer = Customer::firstWhere('id', $ticketId);
            /** check lucky prize */
            $prize = LuckyPrize::firstWhere('prize', 'Cash');
            if (!$prize) {
                $prize = LuckyPrize::create([
                    'prize' => 'Cash',
                    'description' => 'Cash'
                ]);
            }

            /**save winner */
            Winner::create([
                    'customer_id'             => $customer->id,
                    'customer_name'           => $customer->name,
                    'customer_cif_number'     => $customer->cif_number,
                    'customer_account_number' => $customer->account_number,
                    'customer_phone'          => $customer->phone_number,
                    'ticket_number'           => $customer->ticket_number,
                    'lucky_prize_id'          => $prize->id,
                    'prize_name'              => $prize->prize,
                    'win_type'                => WinType::CashPrize,
                    'win_at'                  => $spinDate,
                ]);

            /** update customer to win */
            $customer->update([
                    'win_at'                 => $spinDate,
                    'win_type'               => WinType::CashPrize,
                ]);
            /** update customer current customer customer not to spin again */
            $spinMonth = $spinDate->month;
            Customer::where('cif_number', $customer->cif_number)->where('account_number',$customer->account_number)
                        ->update(['status' => 'INACTIVE']);

            /** find if that winner is the top 10 */
            $customer = Winner::where('win_type', WinType::CashPrize)->whereMonth('win_at', $spinMonth)->count();
        });

        return redirect()->back();
    }

    //====================== save winner parasol ========================
    public function saveParasolPriceWinner($ticketId)
    {
        DB::transaction(function () use ($ticketId) {
            $spinDate = $this->getLuckyDrawDate();
            $customer = Customer::firstWhere('id', $ticketId);
            /** check lucky prize */
            $prize = LuckyPrize::firstWhere('prize', 'Parasol');
            if (!$prize) {
                $prize = LuckyPrize::create([
                    'prize' => 'Parasol',
                    'description' => 'Parasol'
                ]);
            }

            /**save winner */
            Winner::create([
                    'customer_id'             => $customer->id,
                    'customer_name'           => $customer->name,
                    'customer_cif_number'     => $customer->cif_number,
                    'customer_account_number' => $customer->account_number,
                    'customer_phone'          => $customer->phone_number,
                    'ticket_number'           => $customer->ticket_number,
                    'lucky_prize_id'          => $prize->id,
                    'prize_name'              => $prize->prize,
                    'win_type'                => WinType::ParasolPrize,
                    'win_at'                  => $spinDate,
                ]);

            /** update customer to win */
            $customer->update([
                    'win_at'                 => $spinDate,
                    'win_type'               => WinType::ParasolPrize,
                ]);
            /** update customer current customer customer not to spin again */
            $spinMonth = $spinDate->month;
            Customer::where('cif_number', $customer->cif_number)->where('account_number',$customer->account_number)
                        ->update(['status' => 'INACTIVE']);

            /** find if that winner is the top 10 */
            $customer = Winner::where('win_type', WinType::ParasolPrize)->whereMonth('win_at', $spinMonth)->count();
        });

        return redirect()->back();
    }


    //====================== save winner water bottle ========================
    public function saveWaterBottlePriceWinner($ticketId)
    {
        DB::transaction(function () use ($ticketId) {
            $spinDate = $this->getLuckyDrawDate();
            $customer = Customer::firstWhere('id', $ticketId);
            /** check lucky prize */
            $prize = LuckyPrize::firstWhere('prize', 'Water Bottle');
            if (!$prize) {
                $prize = LuckyPrize::create([
                    'prize' => 'Water Bottle',
                    'description' => 'Water Bottle'
                ]);
            }

            /**save winner */
            Winner::create([
                    'customer_id'             => $customer->id,
                    'customer_name'           => $customer->name,
                    'customer_cif_number'     => $customer->cif_number,
                    'customer_account_number' => $customer->account_number,
                    'customer_phone'          => $customer->phone_number,
                    'ticket_number'           => $customer->ticket_number,
                    'lucky_prize_id'          => $prize->id,
                    'prize_name'              => $prize->prize,
                    'win_type'                => WinType::WaterBottlePrize,
                    'win_at'                  => $spinDate,
                ]);

            /** update customer to win */
            $customer->update([
                    'win_at'                 => $spinDate,
                    'win_type'               => WinType::WaterBottlePrize,
                ]);
            /** update customer current customer customer not to spin again */
            $spinMonth = $spinDate->month;
            Customer::where('cif_number', $customer->cif_number)->where('account_number',$customer->account_number)
                        ->update(['status' => 'INACTIVE']);

            /** find if that winner is the top 10 */
            $customer = Winner::where('win_type', WinType::WaterBottlePrize)->whereMonth('win_at', $spinMonth)->count();
        });

        return redirect()->back();
    }
    public function getMontlyPrizeWinner()
    {
        $currentMonth = $this->getLuckyDrawDate()->month;
        $winners = Winner::join('customers', 'customers.id', '=', 'winners.customer_id')
                    ->select('winners.*')
                    ->where('winners.win_type', WinType::MotorBikePrize)
                    ->get();
        return response()->json($winners);
    }

    public function getCashPrizeWinner()
    {
        $currentMonth = $this->getLuckyDrawDate()->month;
        $winners = Winner::join('customers', 'customers.id', '=', 'winners.customer_id')
                    ->select('winners.*')
                    ->where('winners.win_type', WinType::CashPrize)
                    ->orderBy('winners.created_at', 'desc')
                    ->get();
        return response()->json($winners);
    }

    public function getParasolPrizeWinner()
    {
        $currentMonth = $this->getLuckyDrawDate()->month;
        $winners = Winner::join('customers', 'customers.id', '=', 'winners.customer_id')
                    ->select('winners.*')
                    ->where('winners.win_type', WinType::ParasolPrize)
                    ->orderBy('winners.created_at', 'desc')
                    ->get();
        return response()->json($winners);
    }
    public function getWaterBottlePrizeWinner()
    {
        $currentMonth = $this->getLuckyDrawDate()->month;
        $winners = Winner::join('customers', 'customers.id', '=', 'winners.customer_id')
                    ->select('winners.*')
                    ->where('winners.win_type', WinType::WaterBottlePrize)
                    ->orderBy('winners.created_at', 'desc')
                    ->get();Log::info($winners);
        return response()->json($winners);
    }

    public function getGrandPrizeWinner()
    {
        $currentMonth = $this->getLuckyDrawDate()->month;
        $winners = Winner::join('tickets', 'tickets.id', '=', 'winners.ticket_id')
                    ->select('winners.*', 'tickets.number as ticket_number')
                    ->whereMonth('winners.win_at', $currentMonth)
                    ->where('winners.win_type', WinType::GrandPrize)
                    ->get();
        return response()->json($winners);
    }
    public function saveGrandPriceWinner($ticketId)
    {
        DB::transaction(function () use ($ticketId) {
            $spinDate = $this->getLuckyDrawDate();
            $ticket = Ticket::firstWhere('id', $ticketId);

            /** check lucky prize */
            $prize = LuckyPrize::firstWhere('prize', 'USD 100 + 10,000 POINTS');
            if (!$prize) {
                $prize = LuckyPrize::create([
                    'prize' => 'USD 100 + 10,000 POINTS',
                    'description' => 'USD 100 + 10,000 POINTS'
                ]);
            }

            /**save winner */
            Winner::create([
                    'customer_id'             => $ticket->customer_id,
                    'customer_name'           => $ticket->customer_name,
                    'customer_cif_number'     => $ticket->customer_cif_number,
                    'customer_account_number' => $ticket->customer_account_number,
                    'customer_phone'          => $ticket->customer_phone,
                    'ticket_id'               => $ticket->id,
                    'lucky_prize_id'          => $prize->id,
                    'prize_name'              => $prize->prize,
                    'win_type'                => WinType::GrandPrize,
                    'win_at'                  => $spinDate,
                ]);

            /** update ticket to win */
            $ticket->update([
                    'win_at'                 => $spinDate,
                    'win_type'               => WinType::GrandPrize,
                    'spind_grand_prize_at'   => $spinDate,
                ]);

            /** update ticket current customer ticket not to spin again */
            Ticket::where('customer_id', $ticket->customer_id)->whereNull('spind_grand_prize_at')->update(['spind_grand_prize_at' => $spinDate]);

            /** find if that winner is the top 3 */
            $spinMonth = $spinDate->month;
            $customer = Winner::where('win_type', WinType::GrandPrize)->whereMonth('win_at', $spinMonth)->count();
            if ((int)$customer >= 3) {
                Ticket::whereNull('spind_grand_prize_at')->update(['spind_grand_prize_at' => $spinDate]);
            }
        });

        return redirect()->back();
    }
    public function sendNotificationMontlyPrizeWinner($ticketId){
        $spinDate = $this->getLuckyDrawDate();
        $customer = Customer::firstWhere('id', $ticketId);
        $subject = ' Your Lucky Draw Ticket Status!';
        $content = " Dear Mr. Customer [Recipient's Name/Participants], We're excited to inform you that your average
                        balance of last month $[Balance Amount] qualifies you for [Number of Tickets] lucky draw ticket(s) this
                        month! Keep your balance up to maximize your chances of winning.
                        Stay tuned for more updates on upcoming lucky draws!
                        Best,
                        The Prince Mobile App Team
                        Noted* actual content from marketing to be providing
                    ";
        $customerName = $customer->name;
        $customerEmail = $customer->email;

        /**send notification by email */
        $sendNofi = new NotificationService();
        $sendNofi->send($subject, $content, $customerName, $customerEmail);
        /**end */


    }
}
