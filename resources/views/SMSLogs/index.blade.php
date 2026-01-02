@extends('layouts.master')
@section('menu')
@include('menu.menu')
@endsection
@section('breadcrumb')
<div class="row page-header">
    <div class="col-lg-6 align-self-center ">
        <h2>Customer SMS Sending</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">{{Auth::user()->name}}</a></li>
            <li class="breadcrumb-item active">List SMS</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-default">
                SMS LOG LIST
            </div>
            <div class="card-body">
                <table id="datatable2" class="table table-striped dt-responsive nowrap">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Status</th>
                            <th>Customer Name</th>
                            <th>Customer Account</th>
                            <th>Customer CIF</th>
                            <th>SMS FROM</th>
                            <th>SMS TO</th>
                            <th>SMS Text</th>
                            <th>SMS URL</th>
                            <th>Send Date</th>
                            <th>Response</th>
                    </thead>
                    <tbody>
                        @foreach($smsLists as $key => $sms)
                        <tr>
                            <td>{{++$key}}</td>
                            <td>{{$sms->status}}</td>
                            <td>{{$sms->customer_name}}</td>
                            <td>{{$sms->customer_account}}</td>
                            <td>{{$sms->customer_cif}}</td>
                            <td>{{$sms->sms_from}}</td>
                            <td>{{$sms->sms_to}}</td>
                            <td>{{$sms->sms_text}}</td>
                            <td>{{$sms->sms_gateway}}</td>
                            <td>{{$sms->send_date}}</td>
                            <td>{{$sms->response}}</td>
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
