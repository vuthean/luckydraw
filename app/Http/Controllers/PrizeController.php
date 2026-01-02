<?php

namespace App\Http\Controllers;

use App\Models\Prize;
use Illuminate\Support\Facades\Auth;

class PrizeController extends Controller
{
    function index()
    {
        if (Auth::user()->role_id == 2) {
            $prizes = Prize::all();//orderBy('prize_id', 'asc');
                // ->first();

            // dd($prizes);
            return response()->json($prizes);
        }

        return redirect()->back();
    }
}
