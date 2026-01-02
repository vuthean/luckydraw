<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Traits\MasterUser;
use Illuminate\Http\Request;
use Carbon\Carbon;
class TicketController extends Controller
{
    use MasterUser;

    public function index(){
        $tickets = Ticket::orderBy('generated_at','desc')->get();
        $isMaster = $this->isMasterUser();
        return view('ticket.index', compact('tickets','isMaster'));
    }
    public function getTicketData(Request $request){
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
            $columnName = 'number';
        }
        $record_query = new Ticket();
        $totalRecords = $record_query->count();
        $totalRecordswithFilter=$record_query->where(function($query) use( $searchValue)
            {
                $query->where('number', 'like', '%' . $searchValue . '%');
                $query->orWhere('customer_name', 'like', '%' . $searchValue . '%');
                $query->orWhere('customer_cif_number', 'like', '%' . $searchValue . '%');
                $query->orWhere('customer_account_number', 'like', '%' . $searchValue . '%');
                $query->orWhere('customer_phone', 'like', '%' . $searchValue . '%');
                $query->orWhere('generated_at', 'like', '%' . $searchValue . '%');
            })->count();
            $records =$record_query->orderBy($columnName, $columnSortOrder)
			->where(function($query) use( $searchValue)
			{
                $query->where('number', 'like', '%' . $searchValue . '%');
                $query->orWhere('customer_name', 'like', '%' . $searchValue . '%');
                $query->orWhere('customer_cif_number', 'like', '%' . $searchValue . '%');
                $query->orWhere('customer_account_number', 'like', '%' . $searchValue . '%');
                $query->orWhere('customer_phone', 'like', '%' . $searchValue . '%');
                $query->orWhere('generated_at', 'like', '%' . $searchValue . '%');
			})
			->skip($start)
			->take($rowperpage)
			->get();
            $data_arr = [];
			foreach ($records as $key => $record) {
				$data_arr[] = array(
                    "no" => $start + ($key+1),
                    "number" => $record->number,
					"customer_name" => $record->customer_name,
					"customer_cif_number" => $record->customer_cif_number,
					"customer_account_number" =>  $record->customer_account_number,
                    "customer_phone" => $record->customer_phone,
                    "generated_at" => Carbon::parse($record->generated_at)->format('Y-m-d'),
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
}
