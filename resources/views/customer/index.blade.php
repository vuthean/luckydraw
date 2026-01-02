@extends('layouts.master')
@section('menu')
@include('menu.menu')
@endsection
@section('breadcrumb')
<div class="row page-header">
    <div class="col-lg-6 align-self-center ">
        <h2>Customer</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">{{Auth::user()->name}}</a></li>
            <li class="breadcrumb-item active">Customer</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-default">
                <!-- modal synce -->
                <div class="modal" tabindex="-1" role="dialog" id="modalConfirmSync">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Confirm sync data from CBS</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                @if(!$isMaster)
                                    <div class="form-group row" style="font-size: 14px;">
                                        <div class="col-sm-3">
                                            <label for=""><span style="color: red;">*</span>Username:</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="username" name="username">
                                        </div>
                                        <div class="col-sm-12"></div>
                                        <div class="col-sm-3">
                                            <label for=""><span style="color: red;">*</span>password:</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="password" class="form-control" id="password" name="password">
                                        </div>
                                    </div>
                                @endif
                                <div style="background: #f4516c73;border-radius: 26px;color: black;;">
                                    <ul style="padding: 10px; font-size: 11px;margin-left: 42px;">
                                        <li>Customer information will be re-generated</li>
                                        <li>Customer Transaction will be re-generated</li>
                                        <li>Customer Ticked will be re-generate</li>
                                        <li>Winner monthly prize for current month will be destroyed</li>
                                        <li>Winner Grand prize for current month will be destroyed</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn dt-button" id="btnConfirmSync">Confirm</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- modal confirm sms -->
                <div class="modal" tabindex="-1" role="dialog" id="modalConfirmSendMessage">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Confirm send SMS to customer</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" style="font-size: 12px;">
                               <span> Are you sour, you want to send sms to customer now ?</span>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn dt-button" id="btnConfirmSendMessage">Yes</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="float-right mt-10">
                    @if($isMaster)
                        <button type="button" class="btn dt-button btn-primary" data-toggle="modal" data-target="#modalConfirmSync"><i class="fa fa-refresh" aria-hidden="true" style="padding-right: 11px;"></i>Sync Customer CBS</button>
                    @endif
                    
                    <button type="button" class="btn dt-button btn btn-success" data-toggle="modal" data-target="#modalConfirmSendMessage"><i class="fa fa-envelope" aria-hidden="true" style="padding-right: 11px;"></i>Send SMS to all Customers</button>
                   
                </div>
                Customer List
            </div>
            <div class="card-body">
                @if (session()->has('alert-warning'))
                <div class="alert alert-warning"><ul><li>{{ session()->get('message') }}</li></ul></div>
                @endif
                @if (session()->has('alert-danger'))
                <div class="alert alert-danger"><ul><li>{{ session()->get('message') }}</li></ul></div>
                @endif
                @if (session()->has('alert-success'))
                <div class="alert alert-success"><ul><li>{{ session()->get('message') }}</li></ul></div>
                @endif
                <table id="customerTable" class="table table-striped ">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>CIF</th> 
                            <th>Account</th>
                            <th>Category</th>
                            <th>Phone</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    {{-- <tbody>
                        @foreach($customers as $key => $customer)
                        <tr>
                            <td>{{++$key}}</td>
                            <td>{{$customer->name}}</td>
                            <td>{{$customer->cif_number}}</td>
                            <td>{{$customer->account_number}}</td>
                            <td>{{$customer->account_category}}</td>
                            <td>{{$customer->phone_number}}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a type="button" href="#" class="btn btn-success send_sms" style=" padding: 4px;font-size: 12px;"
                                        data-toggle            = "modal"
                                        data-target            = "#modal-send-sms"
                                        data-customer_id       = "{{$customer->id}}"
                                        data-customer_name     = "{{$customer->name}}"
                                        data-customer_cif      = "{{$customer->cif_number}}"
                                        data-customer_account  = "{{$customer->account_number}}"
                                        data-customer_category = "{{$customer->account_category}}"
                                        data-customer_phone    = "{{$customer->phone_number}}"
                                    ><i class="fa fa-envelope" aria-hidden="true" style="padding-right: 11px;"></i>SMS</a>

                                    <a type="button" href="#" class="btn btn-primary update_phone" style=" padding: 4px;font-size: 12px;"
                                        data-toggle            = "modal"
                                        data-target            = "#modal-update-phone"
                                        data-edit_customer_id       = "{{$customer->id}}"
                                        data-edit_customer_name     = "{{$customer->name}}"
                                        data-edit_customer_cif      = "{{$customer->cif_number}}"
                                        data-edit_customer_account  = "{{$customer->account_number}}"
                                        data-edit_customer_category = "{{$customer->account_category}}"
                                        data-edit_customer_phone    = "{{$customer->phone_number}}"
                                    ><i class="fa fa-pencil-square-o" aria-hidden="true" style="padding-right: 11px;"></i>Edit</a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody> --}}
                </table>

                <!-- modal used for send sms to specific user -->
                <div class="modal" tabindex="-1" role="dialog" id="modal-send-sms">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Confirm send SMS to customer</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="post" action="{{ route('customer/send-sms/sepcific') }}" enctype="multipart/form-data" id="form_send_sms">
                                @csrf
                                <div class="modal-body" style="font-size: 12px;">
                                    <input type="hidden" name="customerId" id="customerId">
                                    <input type="hidden" name="isMonthyPrize" id="isMonthyPrize">
                                    <span style="font-size: 15px;"> Are you sour, you want to send sms to this customer ?</span>
                                    <ul style="margin-left: 38px;">
                                        <li>Name     : <span name="customerName"     id="customerName">    </span></li>
                                        <li>CIF      : <span name="customerCIF"      id="customerCIF">     </span></li>
                                        <li>Number   : <span name="customerNumber"   id="customerNumber">  </span></li>
                                        <li>Category : <span name="customerCategory" id="customerCategory"></span></li>
                                        <li>Phone    : <span name="customerPhone"    id="customerPhone">   </span></li>
                                    </ul>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-success " style="cursor: pointer;" id='send_sms_monthly_prize'>Yes</button>
                                    <!-- <button type="button" class="btn btn-success " style="cursor: pointer;" id='send_sms_monthly_prize'>Send Monthly Prize tickets</button> -->
                                    <!-- <button type="button" class="btn btn-primary " style="cursor: pointer;" id='send_sms_grand_prize'>Send Grand Prize tickets</button> -->
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- modal used for update customer phone number -->
                <div class="modal" tabindex="-1" role="dialog" id="modal-update-phone">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Confirm send SMS to customer</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="post" action="{{ route('customer/update/phone') }}" enctype="multipart/form-data" id="frm_save">
                                @csrf
                                <div class="modal-body" style="font-size: 12px;">
                                    <input type="hidden" name="editCustomerId" id="editCustomerId">
                                    <span style="font-size: 15px;"> Are you sour, you want to update customer phone number ?</span>
                                    <ul style="margin-left: 38px;">
                                        <li>Name     : <span name="editCustomerName"     id="editCustomerName">    </span></li>
                                        <li>CIF      : <span name="editCustomerCIF"      id="editCustomerCIF">     </span></li>
                                        <li>Number   : <span name="editCustomerNumber"   id="editCustomerNumber">  </span></li>
                                        <li>Category : <span name="editCustomerCategory" id="editCustomerCategory"></span></li>
                                        <li>Phone    : <input name="editCustomerPhone" id="editCustomerPhone">   </span></li>
                                    </ul>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success ">Yes</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script type="text/javascript">
 $(document).on('click', '.send_sms', function() {

    var customerId       = $(this).data('customer_id');
    var customerName     = $(this).data('customer_name');
    var customerCIF      = $(this).data('customer_cif');
    var customerNumber   = $(this).data('customer_account');
    var customerCategory = $(this).data('customer_category');
    var customerPhone    = $(this).data('customer_phone');

    $('#customerId').val(customerId);
    $("#customerName").html(customerName);
    $("#customerCIF").html(customerCIF);
    $("#customerNumber").html(customerNumber);
    $("#customerCategory").html(customerCategory);
    $("#customerPhone").html(customerPhone);
});

$(document).on('click', '.update_phone', function() {

    var customerId       = $(this).data('edit_customer_id');
    var customerName     = $(this).data('edit_customer_name');
    var customerCIF      = $(this).data('edit_customer_cif');
    var customerNumber   = $(this).data('edit_customer_account');
    var customerCategory = $(this).data('edit_customer_category');
    var customerPhone    = $(this).data('edit_customer_phone');

    $('#editCustomerId').val(customerId);
    $("#editCustomerName").html(customerName);
    $("#editCustomerCIF").html(customerCIF);
    $("#editCustomerNumber").html(customerNumber);
    $("#editCustomerCategory").html(customerCategory);
    $("#editCustomerPhone").val(customerPhone);
});

$('#send_sms_monthly_prize').click(function(e)
{
    $('#isMonthyPrize').val(true);
    $('#form_send_sms').submit();
});

$('#send_sms_grand_prize').click(function(e)
{
    $('#isMonthyPrize').val(false);
    $('#form_send_sms').submit();
});

$('#btnConfirmSync').click(function(e) {
    e.preventDefault();
        let username = $('#username').val();
        let password = $('#password').val();
        $.ajax({
            url: "customer/sync-cbs",
            type: 'post',
            dataType: 'json',
            data:{username,password,_token: '{{csrf_token()}}'},
          success:function(response){
            if(response['reposnseCode'] == '401'){
                alert('Invalid Username or Password');
            }else{
                location.reload();
            }
          },
    });
});
$('#btnConfirmSendMessage').click(function(e) {
    e.preventDefault();
        $.ajax({
            url: "customer/sensms",
            type: 'get',
            dataType: 'json',
          success:function(response){
            location.reload();
          },
    });
});

</script>
<script type="text/javascript">
    $(document).ready(function() {

        // DataTable
        $('#customerTable').DataTable({
            dom: 'Bfrtip',      
            lengthMenu: [
                  [ 10, 25, 50, 100,500 ],
                  [ '10 rows', '25 rows', '50 rows', '100 rows','500 rows' ]
               ], 
            buttons: [
                'pageLength',
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ],
            "pageLength": 10,
            processing: true,
            serverSide: true,
            ordering:  true,
            searching: true,
            ajax: "{{ route('get-customer-data') }}",
            columnDefs: [ {
                    targets: 6,
                    orderable: false
                }],
            columns: [{
                    data: 'no',
                    name: 'no'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'cif_number',
                    name: 'cif_number'
                },
                {
                    data: 'account_number',
                    name: 'account_number'
                },
                {
                    data: 'account_category',
                    name: 'account_category'
                },
                {
                    data: 'phone_number',
                    name: 'phone_number'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        });

    });
</script>
@endsection
