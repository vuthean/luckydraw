@extends('layouts.master')
@section('style')
@include('customer.upload.style')
@endsection
@section('menu')
@include('menu.menu')
@endsection
@section('breadcrumb')
<div class="row page-header">
    <div class="col-lg-6 align-self-center ">
        <h2>Customer</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">{{Auth::user()->name}}</a></li>
            <li class="breadcrumb-item active">Customer Information</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-default">
                <form action="" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" id="user_id" value="{{$userId}}">
                    <div class="float-right mt-10">
                         <a href="{{ asset('templates/template_customer.xlsx') }}" download>
                        <label class="btn btn-primary btn-rounded box-shadow download-file" id="upload-excel-label" >
                            <i class="fa fa-download" aria-hidden="true"></i></i>
                          Template
                        </label></a>
                        <label class="btn btn-primary btn-rounded box-shadow" id="upload-excel-label" for="upload-excel">
                            <i class="fa fa-upload" aria-hidden="true"></i>
                            <input type="file" name="upload-excel" id="upload-excel">Upload Customer
                        </label>
                        <label href="#modalDownloadfile" data-toggle="modal" class="btn btn-primary btn-rounded box-shadow " id="upload-excel-label" >
                            <i class="fa fa-download" aria-hidden="true"></i> Error File
                        </label>
                        <label href="#modalDeleteCustomer" data-toggle="modal" class="btn btn-primary btn-rounded box-shadow " id="upload-excel-label" >
                             Delete Customer
                        </label>
                    </div>
                </form>
                Customer Listing
            </div>
            <div class="card-body ">
                <table id="customerUploadTable" class="table table-striped dt-responsive nowrap">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>CIF</th>
                            <th>Owner Name</th>
                            <th>Account Number</th>
                            <th>Phone Number</th>
                            <th>CIF Location</th>
                            <th>ticket_number</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!--  Upload File Unsucessfully Modal HTML -->
        <div id="myModal" class="modal fade">
            <div class="modal-dialog modal-confirm">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="icon-box">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </div>				
                        <h4 class="modal-title w-100 text-center">Sorry!</h4>	
                    </div>
                    <div class="modal-body">
                        <p class="text-center w-100" id="message-error-from-api"></p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger btn-block" data-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>  
        <!-- Upload File Sucessfully Modal HTML -->
        <div id="myModalSuccess" class="modal fade">
            <div class="modal-dialog modal-confirm">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="icon-box bg-success">
                            <i class="fa fa-check" aria-hidden="true"></i>
                        </div>				
                        <h4 class="modal-title w-100 text-center">Awesome!</h4>	
                    </div>
                    <div class="modal-body">
                        <p class="text-center">Your File uploaded successfully.</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success btn-block btn-success-upload" data-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Download file Modal HTML  -->
        <div id="modalDownloadfile" class="modal fade">
            <div class="modal-dialog modal-confirm">
                <div class="modal-content">
                    <div class="modal-header download-modal-header">			
                        <h6 class="modal-title">Please Select Day</h6>	
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body ">
                        <form class="form-inline">
                            <div class="input-group mb-2 mr-sm-2">
                              <input type="date" class="form-control" id="date-error" placeholder="Erorr Date">
                            </div>
                            <button type="button" class="btn btn-info mb-2" id='search-file'><i class="fa fa-search" aria-hidden="true"></i></button>
                        </form>
                        <p id='error-search-file'></p>
                        <ul class="list-group" id="fileList">

                        </ul>
                    </div>
                    
                    <div class="modal-footer download-modal-footer">
                        <a href="#" class="btn btn-info" data-dismiss="modal">Cancel</a>
                        {{-- <a href="#" class="btn btn-danger disabled"><i class="fa fa-download" aria-hidden="true"></i></a> --}}
                    </div>
                </div>
            </div>
        </div>       
        <!-- Delete All Customer Modal HTML  -->
        <div id="modalDeleteCustomer" class="modal fade">
            <div class="modal-dialog modal-confirm-delete-user modal-confirm">
                <div class="modal-content">
                    <div class="modal-header download-modal-header">	
                        <h3 class="modal-title">Delete all Customer</h3>	
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body ">
                        <h6 class="modal-title text-center">Are you sure for deleting all Customer?</h6>	
                    </div>
                    
                    <div class="modal-footer download-modal-footer">
                        <a href="#" class="btn btn-info" data-dismiss="modal">No</a>
                        <a href="#" class="btn btn-danger" id='btn-delete-all-customer'>Yes</a>
                    </div>
                </div>
            </div>
        </div> 
        <!-- Delete Customer Sucessfully Modal HTML -->
        <div id="myModalDeleteCusSuccess" class="modal fade">
            <div class="modal-dialog modal-confirm">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="icon-box bg-success">
                            <i class="fa fa-check" aria-hidden="true"></i>
                        </div>				
                        <h4 class="modal-title w-100 text-center">Awesome!</h4>	
                    </div>
                    <div class="modal-body">
                        <p class="text-center">You deleted all Customer successfully.</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success btn-block btn-success-upload" data-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>      
    </div>
</div>
@include('layouts.overlay')
@section('javascript')
@include('customer.upload.script')
<script>
    function fClearWinners() {
        var confirmToDelete = confirm("Winners in this campaign will be deleted!!! Are you sure you want to do this?");
        if (confirmToDelete == true) {
            $.ajax({
                type: 'get',
                url: 'win/update',
                success: function(data) {
                    alert("Records have been cleared!");
                    window.location.reload(true);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            })

        }
    }
</script>
<script type="text/javascript">
    $(document).ready(function() {

        // DataTable
        $('#customerUploadTable').DataTable({
            dom: 'Bfrtip',      
            lengthMenu: [
                [10, 25, 50, -1],
                ['10 rows', '25 rows', '50 rows', 'Show all']
            ],
            buttons: [
                'pageLength',
            ],
            "pageLength": 10,
            processing: true,
            serverSide: true,
            ordering:  true,
            searching: true,
            // scrollCollapse: true,

            ajax: {
                url: "{{ route('get-customer-data-upload') }}",
                method: "GET",
                data: function(data) {

                    // var role = $('#role').val();
                    // var first_name = $('#first_name').val();
                    // var last_name = $('#last_name').val();
                    // var create_date = $('#created_date').val();

                    // data.role = role;
                    // data.first_name = first_name;
                    // data.last_name = last_name;
                    // data.create_date = create_date;

                },
            },
            order: [[6, 'desc' ]],
            columns: [{
                    data: 'no',
                    name: 'no'
                },
                {
                    data: 'cif_number',
                    name: 'cif_number'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'account_number',
                    name: 'account_number'
                },
                {
                    data: 'phone_number',
                    name: 'phone_number'
                },
                {
                    data: 'cif_location',
                    name: 'cif_location'
                },
                {
                    data: 'ticket_number',
                    name: 'ticket_number'
                }
            ]
        });

    });
</script>
@endsection

@endsection
