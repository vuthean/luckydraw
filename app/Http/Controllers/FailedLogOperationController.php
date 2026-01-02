<?php

namespace App\Http\Controllers;

use App\Models\FailedLogOperation;
use App\Traits\MasterUser;
use Illuminate\Http\Request;

class FailedLogOperationController extends Controller
{
    use MasterUser;
    public function index()
    {
        $logs = FailedLogOperation::orderBy('created_at', 'DESC')->get();
        $isMaster = $this->isMasterUser();
        return view('failedLogOperations.index', compact('logs','isMaster'));
    }
}
