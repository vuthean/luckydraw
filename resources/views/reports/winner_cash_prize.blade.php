@extends('layouts.master')
@section('menu')
@include('menu.menu')
@endsection
@section('breadcrumb')
<div class="row page-header">
    <div class="col-lg-6 align-self-center ">
        <h2>Report</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">{{Auth::user()->name}}</a></li>
            <li class="breadcrumb-item active">Report</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-default">
                Report Winner For Cash Prize
            </div>
            <div class="card-body">
                @if (session()->has('message'))
                <div class="alert alert-success">
                    <ul>
                        <li>{{ session()->get('message') }}</li>
                    </ul>
                </div>
                @endif
                <table id="datatable2" class="table table-striped dt-responsive nowrap">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Ticket Number</th>
                            <th>Customer Name</th>
                            <th>Customer Phone</th>
                            <th>Customer CIF</th>
                            <th>PRIZE</th>
                            <th>WIN DATE</th>
                    </thead>
                    <tbody>
                        @foreach($winners as $key => $winner)
                        <tr>
                            <td>{{++$key}}</td>
                            <td>{{$winner->ticket_number}}</td>
                            <td>{{$winner->customer_name}}</td>
                            <td>{{$winner->customer_phone}}</td>
                            <td>{{$winner->customer_cif_number}}</td>
                            <td>{{$winner->prize_name}}</td>
                            <td>{{$winner->win_at}}</td>
                        </tr>
                        @endforeach
                    </tbody>
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
@endsection
