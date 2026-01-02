<?php

namespace App\Http\Controllers;

use App\Models\SMSLog;
use App\Traits\LuckyDrawDate;
use App\Traits\MasterUser;

class SMSLogController extends Controller
{
    use LuckyDrawDate, MasterUser;

    public function index()
    {
        $spinDate = $this->getLuckyDrawDate();
        $spinMonth = $spinDate->month;
        $smsLists = SMSLog::whereMonth('send_for_spin_date', $spinMonth)->orderBy('send_for_spin_date', 'DESC')->get();
        $isMaster = $this->isMasterUser();
        return view('SMSLogs.index', compact('smsLists', 'isMaster'));
    }
}
