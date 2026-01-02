<?php

namespace App\Http\Controllers;

use App\Models\AllTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class generateTicket extends Controller
{
    public function index()
    {
        $export_service = new ExportDataService();
        $export_service->export();
    }

        public function sendSMS()
    {
        $export_service = new ExportDataService();
        $export_service->sendSMS();
    }
}
