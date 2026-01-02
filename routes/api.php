<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerUploadController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/customer/upload-excel', [CustomerUploadController::class, 'uploadExcel'])->name('customer/upload-excel');
Route::post('/customer/upload-error', [CustomerUploadController::class, 'uploadError'])->name('customer/upload-error');
Route::delete('/customer/delete-all', [CustomerUploadController::class, 'deleteAllCustomer'])->name('customer/delete-all');

