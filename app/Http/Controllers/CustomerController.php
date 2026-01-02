<?php

namespace App\Http\Controllers;

use App\Enums\SMSStatus;
use App\Events\CustomerImported;
use App\Models\Customer;
use App\Models\Ticket;
use App\Models\Winner;
use App\Services\CBSDataImportService;
use App\Services\SMSService;
use App\Traits\LuckyDrawDate;
use App\Traits\MasterUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use phpDocumentor\Reflection\Types\This;

class CustomerController extends Controller
{
    use LuckyDrawDate;
    use MasterUser;

    public function index()
    {
        $customers = Customer::get();
        $isMaster   = $this->isMasterUser();
        return view('customer.index', compact('customers', 'isMaster'));
    }
    public function getCustomerData(Request $request){
        $draw = $request->get('draw');
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
            })->count();
            $records =$record_query->orderBy($columnName, $columnSortOrder)
			->where(function($query) use( $searchValue)
			{
                $query->where('name', 'like', '%' . $searchValue . '%');
                $query->orWhere('cif_number', 'like', '%' . $searchValue . '%');
                $query->orWhere('account_number', 'like', '%' . $searchValue . '%');
                $query->orWhere('account_category', 'like', '%' . $searchValue . '%');
                $query->orWhere('phone_number', 'like', '%' . $searchValue . '%');
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
                    'action' =>  $action
				);
			}
			$response = array(
				"draw" => intval($draw),
				"iTotalRecords" => $totalRecords,
				"iTotalDisplayRecords" => $totalRecordswithFilter,
				"aaData" => $data_arr
			);
			return response()->json($response);
    }
    public function importCustomers(Request $request)
    {
        DB::transaction(function () {
            /** clean all data by lucky draw month */
            $luckyDrawDate = $this->getLuckyDrawDate();
            $month = $luckyDrawDate->month;

            /** destroy winner on month */
            Winner::whereMonth('win_at', $month)->delete();

            /** destroy ticket generate on month */
            Ticket::whereMonth('generated_at', $month)->delete();

            /** import customer */
            $cbsService = new CBSDataImportService();
            $customers = $cbsService->importCustomer();
            if (collect($customers)->isEmpty()) {
                Session::flash('error', 'Import data has problem please contact administrator.');
                return redirect()->back();
            }

            /** rais event for generate ticket */
            CustomerImported::dispatch($month);
        });
        Session::flash('message', 'Data was synced success fully from CBS');
        return response(['reposnseCode'=>'200','data'=>'Success'], 200);
    }

    public function sensms(Request $request)
    {

        /** find customer that has ticket for current lucky date */
        $luckyDrawDate = $this->getLuckyDrawDate();
        $month         = $luckyDrawDate->month;
        $tickets = Ticket::whereMonth('generated_at', $month)
                ->whereNull('spind_monthly_prize_at')
                ->whereNull('spind_grand_prize_at')
                ->whereNull('win_at')
                ->get();

        /** find customer */
        $customerIds   =  collect($tickets)->pluck('customer_id')->unique()->all();
        $responses     = [];
        foreach ($customerIds as $customerId) {
            /** get all ticket for current customer  */
            $ticketNumbers    = collect($tickets)->where('customer_id', $customerId)->pluck('number');
            $ticketNumberStrs = collect($ticketNumbers)->implode(',');

            /** count ticket for current customer */
            $tocketAmount     = collect($ticketNumbers)->count();

            /** send sms to each customer phone number */
            $customerTicket    = collect($tickets)->firstWhere('customer_id', $customerId);

            /** message template */
            $setting        = config('setting');
            $messageContent = $setting['message_content'];
            $content        = __($messageContent, [
             'tocketAmount' => $tocketAmount,
             'tiketNumbers' => $ticketNumberStrs
         ]);
            $smsService  = new SMSService();
            $response = $smsService->send(
                $customerName    = $customerTicket['customer_name'],
                $customerCif     = $customerTicket['customer_cif_number'],
                $customerAccount = $customerTicket['customer_account_number'],
                $phone           = $customerTicket['customer_phone'],
                $message         = $content
            );
            array_push($responses, $response);
        }

        $totalSuccess = collect($responses)->where('message', SMSStatus::Success)->count();
        $totalFailed  = collect($responses)->where('message', SMSStatus::Failed)->count();
        if ($totalSuccess > 0 &&  $totalFailed > 0) {
            Session::flash('message', "SMS has been send but suscess: {$totalSuccess} and Failed: {$totalFailed}");
            Session::flash('alert-warning', "");
            return response(['reposnseCode'=>'001','data'=>'Success'], 200);
        } elseif ($totalFailed > 0) {
            Session::flash('message', "SMS cannot send because of some reason please check report auditlog for Sending SMS.");
            Session::flash('alert-danger', "");
            return response(['reposnseCode'=>'002','data'=>'Success'], 200);
        } else {
            Session::flash('message', "SMS has been send successfully.");
            Session::flash('alert-success', "");
            return response(['reposnseCode'=>'000','data'=>'Success'], 200);
        }
    }
    public function sendSMSToCustomer(Request $request)
    {
        $customerId = $request->customerId;

        /** find customer that has ticket for current lucky date */
        $luckyDrawDate = $this->getLuckyDrawDate();
        $month         = $luckyDrawDate->month;

        $tickets = [];

        /** check sms type to send */
        if ($request->isMonthyPrize) {
            $tickets = Ticket::whereMonth('generated_at', $month)
                    ->where('customer_id', $customerId)
                    ->whereNull('spind_monthly_prize_at')
                    ->whereNull('spind_grand_prize_at')
                    ->whereNull('win_at')
                    ->get();
        }else{
            $tickets = Ticket::where('customer_id', $customerId)
                    ->whereNull('spind_grand_prize_at')
                    ->whereNull('win_at')
                    ->get();
        }

        if (collect($tickets)->isEmpty()) {
            Session::flash('message', "This customer does not has any ticket to send.");
            Session::flash('alert-warning', "");
            return redirect()->route('customer');
        }

        /** get all ticket for current customer  */
        $ticketNumbers    = collect($tickets)->where('customer_id', $customerId)->pluck('number');
        $ticketNumberStrs = collect($ticketNumbers)->implode(',');

        /** count ticket for current customer */
        $tocketAmount     = collect($ticketNumbers)->count();

        /** send sms to each customer phone number */
        $customerTicket    = collect($tickets)->firstWhere('customer_id', $customerId);

        /** message template */
        $setting        = config('setting');
        $messageContent = $setting['message_content'];
        $content        = __($messageContent, [
             'tocketAmount' => $tocketAmount,
             'tiketNumbers' => $ticketNumberStrs
         ]);

        $smsService  = new SMSService();
        $response = $smsService->send(
            $customerName    = $customerTicket['customer_name'],
            $customerCif     = $customerTicket['customer_cif_number'],
            $customerAccount = $customerTicket['customer_account_number'],
            $phone           = $customerTicket['customer_phone'],
            $message         = $content
        );

        Session::flash('message', "SMS has been send successfully.");
        Session::flash('alert-success', "");
        return redirect()->route('customer');
    }

    public function updateCustomerPhone(Request $request)
    {
        /** update table customer */
        $customer = Customer::firstWhere('id', $request->editCustomerId);
        if (!$customer) {
            Session::flash('message', "Update phone is not success : {$request->editCustomerId}");
            Session::flash('alert-danger', "");
            return redirect()->route('customer');
        }

        $success = DB::transaction(function () use ($customer, $request) {
            /**update phone */
            $customer->update(['phone_number'=>$request->editCustomerPhone]);

            /** update phone in ticket table */
            Ticket::where('customer_id', $customer->id)->update(['customer_phone'=> $request->editCustomerPhone]);

            return true;
        });

        if ($success) {
            Session::flash('message', "Phone update successfully");
            Session::flash('alert-success', "");
            return redirect()->route('customer');
        }

        Session::flash('message', "Update phone is not success");
        Session::flash('alert-danger', "");
        return redirect()->route('customer');
    }
}
