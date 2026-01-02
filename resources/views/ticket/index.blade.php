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
            <div class="col-sm-12" style="padding-left: 0px;">
                <div class="form-inline">  
                    <input type="date" id="start_date" name="start_date" class="form-control mb-2 mr-sm-2" >
                    <span style="padding-right: 8px;">TO</span>
                    <input type="date" id="end_date" name="end_date" class="form-control mb-2 mr-sm-2" >
                    <button id="btn_searh" class="btn btn-sm btn-primary mb-2" style="height: 36px; font-size: 14px;">Search</button>  
                </div>
            </div>
        <div class="card">
            <div class="card-header card-default">
                All Ticket List
            </div>
            <div class="card-body">
                @if (session()->has('message'))
                <div class="alert alert-success">
                    <ul>
                        <li>{{ session()->get('message') }}</li>
                    </ul>
                </div>
                @endif
                <table id="ticketTable" class="table table-striped dt-responsive">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Ticket Number</th>
                            <th>Customer Name</th>
                            <th>Customer CIF</th>
                            <th>Customer Account</th>
                            <th>Customer Phone</th>
                            <th>Generated Date</th>
                    </thead>
                    {{-- <tbody>
                        @foreach($tickets as $key => $tickets)
                        <tr>
                            <td>{{++$key}}</td>
                            <td>{{$tickets->number}}</td>
                            <td>{{$tickets->customer_name}}</td>
                            <td>{{$tickets->customer_cif_number}}</td>
                            <td>{{$tickets->customer_account_number}}</td>
                            <td>{{$tickets->customer_phone}}</td>
                            <td>{{$tickets->generated_at}}</td>
                        </tr>
                        @endforeach
                    </tbody> --}}
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script>
        $(document).ready(function()
        {
            var table = $('#datatable2').DataTable(); 
            $('#btn_searh').on('click', function() {
                table.draw();
            });   
           
        });

        $.fn.dataTable.ext.search.push(
            function( settings, data, dataIndex ) {
                var dStart = new Date($('#start_date').val());
                var dEnd   = new Date($('#end_date').val());
                var dData  = new Date(data[6]);

                var search =parseFloat( dData.getTime()) || 0; // use data for the create date column 
                var min = parseFloat(dStart.getTime()) || search;
                var max = parseFloat(dEnd.getTime()) || search;  
 
                if ( ( isNaN( min ) && isNaN( max ) ) ||
                    ( isNaN( min ) && search <= max ) ||
                    ( min <= search   && isNaN( max ) ) ||
                    ( min <= search   && search <= max ) )
                {
                    return true;
                }
                return false;
            }
         );
   
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
    
            // DataTable
            $('#ticketTable').DataTable({
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
                ajax: "{{ route('get-ticket-data') }}",
                order: [[6, 'desc' ]],
                columnDefs: [ {
                        targets: 6,
                        orderable: false
                    }],
                columns: [{
                        data: 'no',
                        name: 'no'
                    },
                    {
                        data: 'number',
                        name: 'number'
                    },
                    {
                        data: 'customer_name',
                        name: 'customer_name'
                    },
                    {
                        data: 'customer_cif_number',
                        name: 'customer_cif_number'
                    },
                    {
                        data: 'customer_account_number',
                        name: 'customer_account_number'
                    },
                    {
                        data: 'customer_phone',
                        name: 'customer_phone'
                    },
                    {
                        data: 'generated_at',
                        name: 'generated_at'
                    }
                ]
            });
    
        });
    </script>
    
@endsection
