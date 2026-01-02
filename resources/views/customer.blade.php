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
                <div class="float-right mt-10">
                    <a href="{{ route('customer/generateTicket') }}" class="btn btn-primary btn-icon btn-rounded box-shadow"><i class="fa fa-plus"></i> Generate Ticket </a>
                    <a href="{{ route('customer/sensms') }}" class="btn btn-primary btn-icon btn-rounded box-shadow"><i class="fa fa-plus"></i> Send SMS </a>
                </div>
                View Input Ticket
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
                            <th>Customer CIF</th>
                            <th>Account Numer</th>
                            <th>Customer Name</th>
                            <th>Phone Number</th>
                            <th>Ticket Number</th>
                            <th>Ticket Date</th>
                    </thead>
                    <tbody>
                        @foreach($allTicket as $key => $allTicket)
                        <tr>
                            <td>{{++$key}}</td>
                            <td>{{$allTicket->customer_CIF}}</td>
                            <td>{{$allTicket->ticket_customerAcctNo}}</td>
                            <td>{{$allTicket->customer_name}}</td>
                            <td>{{$allTicket->customer_TEL}}</td>
                            <td>{{$allTicket->ticket_number}}</td>
                            <td>{{$allTicket->ticket_date}}</td>
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

@endsection
