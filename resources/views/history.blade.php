@extends('layouts.master')
@section('menu')
@include('menu.menu')
@endsection
@section('breadcrumb')
<div class="row page-header">
    <div class="col-lg-6 align-self-center ">
        <h2>History</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">{{Auth::user()->name}}</a></li>
            <li class="breadcrumb-item active">History</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-default">
                <!-- <div class="float-right mt-10">
                    <a href="javascript:fClearWinners()" class="btn btn-primary btn-rounded box-shadow">Clear All Winner</a>
                </div> -->
                Winner Last Event
            </div>
            <div class="card-body">
                <table id="datatable2" class="table table-striped dt-responsive nowrap">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Customer Name</th>
                            <th>Phone Number</th>
                            <th>Ticket Number</th>
                            <th>Prize</th>
                            <th>Lucky Draw Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($winners as $key => $all_winner)
                        <tr>
                            <td>{{++$key}}</td>
                            <td>{{$all_winner->customer_name}}</td>
                            <td>{{$all_winner->customer_phone}}</td>
                            <td>{{$all_winner->ticket_number}}</td>
                            <td>{{$all_winner->prize_name}}</td>
                            <td>{{$all_winner->win_at}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
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
</div>

@endsection
