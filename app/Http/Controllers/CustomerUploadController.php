<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use App\Utils\ApiResponse;
use App\Utils\HttpRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Customer;
use App\Models\CustomerUpload;
use App\Models\History;
use App\Models\Winner;

class CustomerUploadController extends Controller
{
    public function index(){
        $userId = Auth::id();
        return view('customer.upload.index',compact('userId'));
    }
    public function getCustomerUploadData(Request $request){
        try {$draw = $request->get('draw');
            $start = $request->get("start");
            $rowperpage = $request->get("length"); // total number of rows per page
            $columnIndex_arr = $request->get('order');
            $columnName_arr = $request->get('columns');
            $order_arr = $request->get('order');
            $search_arr = $request->get('search');
            $columnIndex = $columnIndex_arr[0]['column']; // Column index
            $columnName = $columnName_arr[$columnIndex]['data']; // Column name
            $columnSortOrder = $order_arr[0]['dir']; // asc or desc
            $searchValue = $search_arr['value']; // Search value
            if($columnName=='no'){
                $columnName = 'name';
            }
            $record_query = new Customer();
            $totalRecords = $record_query->count();
            $totalRecordswithFilter=$record_query->where(function($query) use( $searchValue)
                {
                    $query->where('name', 'like', '%' . $searchValue . '%');
                    $query->orWhere('cif_number', 'like', '%' . $searchValue . '%');
                    $query->orWhere('account_number', 'like', '%' . $searchValue . '%');
                    $query->orWhere('account_category', 'like', '%' . $searchValue . '%');
                    $query->orWhere('phone_number', 'like', '%' . $searchValue . '%');
                    $query->where('ticket_number', 'like', '%' . $searchValue . '%');
                })->count();
                $records =$record_query->orderBy($columnName, $columnSortOrder)
                ->where(function($query) use( $searchValue)
                {
                    $query->where('name', 'like', '%' . $searchValue . '%');
                    $query->orWhere('cif_number', 'like', '%' . $searchValue . '%');
                    $query->orWhere('account_number', 'like', '%' . $searchValue . '%');
                    $query->orWhere('account_category', 'like', '%' . $searchValue . '%');
                    $query->orWhere('phone_number', 'like', '%' . $searchValue . '%');
                    $query->where('ticket_number', 'like', '%' . $searchValue . '%');
                })
                ->skip($start)
                ->take($rowperpage)
                ->get();
                $data_arr = [];
                foreach ($records as $key => $record) {
                    $action = '<div class="btn-group" role="group" aria-label="Basic example">
                    <a type="button" href="#" class="btn btn-success send_sms" style=" padding: 4px;font-size: 12px;"
                        data-toggle            = "modal"
                        data-target            = "#modal-send-sms"
                        data-customer_id       = "'.$record->id.'"
                        data-customer_name     = "'.$record->name.'"
                        data-customer_cif      = "'.$record->cif_number.'"
                        data-customer_account  = "'.$record->account_number.'"
                        data-customer_category = "'.$record->account_category.'"
                        data-customer_phone    = "'.$record->phone_number.'"
                    ><i class="fa fa-envelope" aria-hidden="true" style="padding-right: 11px;"></i>SMS</a>
    
                    <a type="button" href="#" class="btn btn-primary update_phone" style=" padding: 4px;font-size: 12px;"
                        data-toggle            = "modal"
                        data-target            = "#modal-update-phone"
                        data-edit_customer_id       = "'.$record->id.'"
                        data-edit_customer_name     = "'.$record->name.'"
                        data-edit_customer_cif      = "'.$record->cif_number.'"
                        data-edit_customer_account  = "'.$record->account_number.'"
                        data-edit_customer_category = "'.$record->account_category.'"
                        data-edit_customer_phone    = "'.$record->phone_number.'"
                    ><i class="fa fa-pencil-square-o" aria-hidden="true" style="padding-right: 11px;"></i>Edit</a>
                </div>';
                    $data_arr[] = array(
                        "no" => $start + ($key+1),
                        "name" => $record->name,
                        "cif_number" => $record->cif_number,
                        "account_number" => $record->account_number,
                        "account_category" =>  $record->account_category,
                        "phone_number" => $record->phone_number,
                        "cif_location" => $record->cif_location,
                        "ticket_number" => $record->ticket_number,
                        'action' =>  $action
                    );
                }
                $response = array(
                    "draw" => intval($draw),
                    "iTotalRecords" => $totalRecords,
                    "iTotalDisplayRecords" => $totalRecordswithFilter,
                    "aaData" => $data_arr
                );
                return response()->json($response); //code...
        } catch (\Throwable $th) {
            Log::info($th);
        }
        
    }
    public function uploadExcel(Request $request)
    {
        $validator = Validator::make(
            $request->all() + ['upload-excel' => $request->file('upload-excel')],
            [
                'upload-excel' => 'required|file|mimes:xlsx,xls',
            ]
        );
        if ($validator->fails()) {
            return ApiResponse::error(ApiResponse::convertValidationErrors($validator->errors()));
        }
        try {
            $userId = $request->userId;
            $file = $request->file('upload-excel');
            $destinationPath = 'files/customer/excels';
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move($destinationPath, $fileName);
            $result = $this->readExcelToArray($fileName, $userId);
            $resultAsArray = $result->getData(true);
            if($resultAsArray['status'] == 'error'){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Some rows failed validation',
                    'invalid_rows' => $resultAsArray['invalid_rows'],
                    'file_name' => $resultAsArray['fileName']
                ], 422);
            }
            return ApiResponse::success(['url' => $destinationPath . '/' . $fileName, 'filename' => $fileName], 'File uploaded successfully.');
        } catch (Exception $e) {
            Log::error('Upload error:', ['message' => $e->getMessage()]);
            return response()->json(['upload-excel' => 'Failed to upload file: ' . $e->getMessage()], 500);
        }
    }
    public function readExcelToArray($fileName ,$userId)
    {
        if ($fileName) {
            if (file_exists(public_path('files/customer/excels/' . $fileName))) {
                $file = public_path('files/customer/excels/' . $fileName);
                $datas = Excel::toArray([], $file);
                $data = $datas[0];

                if (empty($data)) {
                    return "No data found in Excel";
                }
                // Current datetime
                $now = Carbon::now();
                $headers = $data[0];
                $rows = array_slice($data, 1); // remove header row
                 // Map Excel columns to database columns
                $headerMap = [
                    'CIF Location'           => 'cif_location',
                    'CIF'                    => 'cif_number',
                    'Owner Name'             => 'name',
                    'Account Number'         => 'account_number',
                    'Phone Number'           => 'phone_number',
                    'Number of Ticket'       => 'ticket_number'
                ];
                 // Remove "No." column if exists
                $filteredIndexes = [];
                foreach ($headers as $index => $header) {
                    if (strtolower(trim($header)) !== 'no.' && isset($headerMap[$header])) {
                        $filteredIndexes[$index] = $headerMap[$header];
                    }
                }
            
                // Build insert array
                $insertData = [];
                foreach ($rows as $rowNumber => $row) {
                    $item = [];
                    foreach ($filteredIndexes as $index => $dbColumn) {
                        $item[$dbColumn] = $row[$index] ?? null;
                    }
                    // Validation
                    $cif = trim($item['cif_number'] ?? '');
                    $account = trim($item['account_number'] ?? '');

                    // Check if cif_number is exactly 8 digits
                    $isValidCif = preg_match('/^\d{8}$/', $cif);
                    // Check if account_number is exactly 9 digits
                    $isValidAccount = preg_match('/^\d{9}$/', $account);

                    if (!$isValidCif || !$isValidAccount) {
                        $invalidRows[] = [
                            'row' => $rowNumber + 2, // +2 because of header offset
                            'keyword' => !$isValidCif ? $cif : $account,
                            'error' => !$isValidCif ? 'Invalid CIF' : 'Invalid Account Number'
                        ];
                        continue; // skip this row
                    }
                     // Add static columns
                    $item['imported_at'] = $now;
                    $item['created_at']  = $now;
                    $item['updated_at']  = $now;
                    $item['created_by']  = $userId;
                    $item['updated_by']  = $userId;
                    $insertData[] = $item;
                }
                // If invalid rows found, stop import and return errors
                if (!empty($invalidRows)) {
                    Log::error([
                        'status' => 'error',
                        'message' => 'Some rows failed validation',
                        'invalid_rows' => $invalidRows,
                    ]);
                    /**store data error when upload customer to new file as text */
                    $data = [
                        'created_at' => now()->toDateTimeString(),
                        'status' => 'error',
                        'message' => 'Some rows failed validation',
                        'invalid_rows' => $invalidRows,
                    ];
                
                    // Convert to readable JSON format
                    $content = json_encode($data, JSON_PRETTY_PRINT);
                
                    // Create directory (if not exists)
                    $path = public_path('files/logs');
                    if (!File::exists($path)) {
                        File::makeDirectory($path, 0755, true);
                    }
                
                    // Create unique filename
                    $filename = 'Invalid_rows_' . now()->format('Ymd_His') . '.txt';
                
                    // Write to file
                    File::put($path . '/' . $filename, $content);
                    /**end */
                    return response()->json([
                        'status'        => 'error',
                        'message'       => 'Some rows failed validation',
                        'invalid_rows'  => $invalidRows,
                        'fileName'      => $filename
                    ], 422);
                }
                // Insert in chunks to avoid memory issues
                $chunks = array_chunk($insertData, 1000); // insert 500 rows at a time
                DB::transaction(function () use ($chunks, $fileName, $userId) {
                    foreach ($chunks as $chunk) {
                        DB::table('customers')->insert($chunk);
                    }
                    
                    CustomerUpload::insertData($fileName, $userId);
                });
                return response()->json([
                    'status'    => 'success',
                    'message'   => 'File uploaded successfully.',
                ], 200);
                
            }
            return [];
        }
    }
    public function uploadError(Request $request){
        try {
            $date = $request->date;
            $path = public_path('files/logs');
            // Get all files once
            $files = collect(File::files($path));

            // Filter using collection )
            $filtered = $files->filter(function ($file) use ($date) {
                return Carbon::createFromTimestamp($file->getMTime())->toDateString() === $date;
            })->map(function ($file) {
                return [
                    'filename' => $file->getFilename(),
                    'url' => asset('files/logs/' . $file->getFilename()),
                    'date' => Carbon::createFromTimestamp($file->getMTime())->toDateString(),
                ];
            })->values();
            // If no file found, return message
            if ($filtered->isEmpty()) {
                return response()->json([
                    'status'    => 'error',
                    'message' => 'No file found.'
                ], 404);
            }
            return ApiResponse::success(['filename' => [$filtered]], 'File uploaded successfully.');
        } catch (Exception $e) {
            Log::error('Upload error:', ['message' => $e->getMessage()]);
            return response()->json(['upload-excel' => 'Can not find file uploaded: ' . $e->getMessage()], 500);
        }
    }
    public function deleteAllCustomer(Request $request){
        try {
            DB::transaction(function () use ($request) {
                $allWinners = Winner::get()->toArray();
                // Remove 'id' from each record
                foreach ($allWinners as &$winner) {
                    unset($winner['id']);
                }
                $result = History::insert($allWinners);
                if($result){
                    Customer::truncate();
                    Winner::truncate();
                }else{
                    return response()->json([
                        'status'    => 'error',
                        'message'   => 'All the customers have not been deleted.',
                    ], 200);
                }
            });
            return response()->json([
                'status'    => 'success',
                'message'   => 'All the customers have been deleted.',
            ], 200);
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }
}
