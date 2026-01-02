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
                            <th>Activity</th>
                            <th>Message</th>
                    </thead>
                    <tbody>
                        @foreach($logs as $key => $log)
                        <tr>
                            <td>{{++$key}}</td>
                            <td>{{$log->activity}}</td>
                            <td>{{$log->message}}</td>
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
