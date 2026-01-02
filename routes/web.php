<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ActivedirectoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FailedLogOperationController;
use App\Http\Controllers\PrizeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SMSLogController;
use App\Http\Controllers\SpinController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\WinController;
use App\Http\Controllers\CustomerUploadController;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
})->name('/');

Route::post('sginin', [ActivedirectoryController::class, 'login'])->name('sginin');
//** view logs */
Route::get('logs', [LogViewerController::class, 'index'])->middleware('auth');
Route::group(['middleware' => 'auth'], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /** ticket */
    Route::get('tickets', [TicketController::class, 'index'])->name('tickets_listing');
    Route::get('get-ticket-data', [TicketController::class, 'getTicketData'])->name('get-ticket-data');
    /** customer  */
    Route::get('customer', [CustomerController::class, 'index'])->name('customer');
    Route::get("customer/save/{customer_CIF}/{customer_name}/{customer_TEL}/{ticket_numberOfTicket}", [CustomerController::class, 'save']);
    Route::get('customer/seachCustomer', [CustomerController::class, 'seachCustomer'])->name('customer/seachCustomer');
    Route::get('customer/check_input', [CustomerController::class, 'check_input'])->name('customer/check_input');
    Route::get('get-customer-data', [CustomerController::class, 'getCustomerData'])->name('get-customer-data');

    Route::get('spin/old-spin', [SpinController::class, 'oldSpin'])->name('old_spin');
    Route::get('spin/grand-prize', [SpinController::class, 'spinGrandPrize'])->name('spin_grand_prize');

    Route::get('spin/getAllTicket', [SpinController::class, 'getAllTicket'])->name('spin/getAllTicket');
    Route::get('getrandom', [SpinController::class, 'getTicket'])->name('getrandom');

    Route::get('prize', [PrizeController::class, 'index'])->name('prize');

    Route::get('win/winnerSave/{prize_id}/{users_id}/{ticket_id}/{customer_CIF}', [WinController::class, 'winnerSave']);
    Route::get('win/getWinner', [WinController::class, 'getWinner'])->name('win/getWinner');
    Route::get('win/update', [WinController::class, 'update'])->name('win/update');


    /** ========= phase2 =================*/
    Route::post('customer/sync-cbs', [CustomerController::class, 'importCustomers'])->middleware('allow.sync')->name('customer/sync-cbs');
    Route::get('customer/sensms', [CustomerController::class, 'sensms'])->name('customer/sensms');
    Route::post('customer/send-sms/sepcific', [CustomerController::class, 'sendSMSToCustomer'])->name('customer/send-sms/sepcific');
    Route::post('customer/update/phone', [CustomerController::class, 'updateCustomerPhone'])->name('customer/update/phone');

    /** Motor Prize */
    Route::get('spin/motor-prize', [SpinController::class, 'spinMonthlyPrize'])->name('spin/motor-prize');
    Route::get('spin/winner/motor-prize', [WinController::class,'getMontlyPrizeWinner'])->name('spin/winner/motor-prize');
    Route::get('spin/tickets/get-random-monthly-prize-ticket', [SpinController::class, 'getRandomTicketForMonthlyPrize'])->name('tickets/get-random-monthly-prize-ticket');
    Route::get('spin/winner/motor-prize-ticket/{ticketId}', [WinController::class,'saveMonthlyPriceWinner'])->name('winner/motor-prize-ticket');

    /** Cash Prize */
    Route::get('spin/cash-prize', [SpinController::class, 'spinCashPrize'])->name('spin/cash-prize');
    Route::get('spin/winner/cash-prize', [WinController::class,'getCashPrizeWinner'])->name('spin/winner/cash-prize');
    Route::get('spin/tickets/get-random-cash-prize-ticket', [SpinController::class, 'getRandomTicketForCashPrize'])->name('tickets/get-random-cash-prize-ticket');
    Route::get('spin/winner/cash-prize-ticket/{ticketId}', [WinController::class,'saveCashPriceWinner'])->name('winner/cash-prize-ticket');

    /** Parasol Prize */
    Route::get('spin/parasol-prize', [SpinController::class, 'spinParasolPrize'])->name('spin/parasol-prize');
    Route::get('spin/winner/parasol-prize', [WinController::class,'getParasolPrizeWinner'])->name('spin/winner/parasol-prize');
    Route::get('spin/tickets/get-random-parasol-prize-ticket', [SpinController::class, 'getRandomTicketForParasolPrize'])->name('tickets/get-random-parasol-prize-ticket');
    Route::get('spin/winner/parasol-prize-ticket/{ticketId}', [WinController::class,'saveParasolPriceWinner'])->name('winner/parasol-prize-ticket');

    /** Water Bottle Prize */
    Route::get('spin/water-bottle-prize', [SpinController::class, 'spinWaterBottlePrize'])->name('spin/water-bottle-prize');
    Route::get('spin/winner/water-bottle-prize', [WinController::class,'getWaterBottlePrizeWinner'])->name('spin/winner/water-bottle-prize');
    Route::get('spin/tickets/get-random-water-bottle-prize-ticket', [SpinController::class, 'getRandomTicketForWaterBottlePrize'])->name('tickets/get-random-water-bottle-prize-ticket');
    Route::get('spin/winner/water-bottle-prize-ticket/{ticketId}', [WinController::class,'saveWaterBottlePriceWinner'])->name('winner/water-bottle-prize-ticket');
    

    /** Grand prize */
    Route::get('spin/grand-prize', [SpinController::class, 'spinGrandPrize'])->name('spin/grand-prize');
    Route::get('spin/winner/grand-prize', [WinController::class,'getGrandPrizeWinner'])->name('spin/winner/grand-prize');
    Route::get('spin/tickets/get-random-grand-prize-ticket', [SpinController::class, 'getRandomTicketForGrandPrize'])->name('tickets/get-random-grand-prize-ticket');
    Route::get('spin/winner/grand-prize-ticket/{ticketId}', [WinController::class,'saveGrandPriceWinner'])->name('winner/grand-prize-ticket');

    /** Reports */
    Route::get('reports/winner/motor-prize', [ReportController::class,'reportWinnerMotorPrize'])->name('reports/winner/motor-prize');
    Route::get('reports/winner/cash-prize', [ReportController::class,'reportWinnerCashPrize'])->name('reports/winner/cash-prize');
    Route::get('reports/winner/parasol-prize', [ReportController::class,'reportWinnerParasolPrize'])->name('reports/winner/parasol-prize');
    Route::get('reports/winner/water-bottle-prize', [ReportController::class,'reportWinnerWaterBottlePrize'])->name('reports/winner/water-bottle-prize');
    Route::get('reports/winner/grand-prize', [ReportController::class,'reportWinnerGrandPrize'])->name('reports/winner/grand-prize');

    //**History */
    Route::get('history', [ReportController::class,'reportWinnerHistoryPrize'])->name('history');

    /** sending SMS */
    Route::get('sending-sms', [SMSLogController::class,'index'])->name('sending-sms');
    Route::get('fail-log-operation', [FailedLogOperationController::class,'index'])->name('fail-log-operation');

    /**upload customer info */
    Route::get('customer/index', [CustomerUploadController::class, 'index'])->name('customer/index');
    Route::get('get-customer-data-upload', [CustomerUploadController::class, 'getCustomerUploadData'])->name('get-customer-data-upload');
});
