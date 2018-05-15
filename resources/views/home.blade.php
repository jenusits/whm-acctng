@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-primary o-hidden h-100">
                <div class="card-body">
                    <div class="card-body-icon">
                        <i class="fas fa-paper-plane"></i>
                    </div>
                    <div class="mr-5" style="">
                    <?php
                        $pendingRequestsCount = \App\Request_funds::getPendingRequests();
                        $pendingRequestsCount = $pendingRequestsCount->count();
                        $prc = $pendingRequestsCount;
                    ?>
                    @if($prc > 0)
                        <strong>{{ $prc }} New @if($prc > 1) Requests!@else Request! @endif</strong>
                    @else
                        There are no Pending Requests!
                    @endif
                    </div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="{{ route('request_funds.index') }}?pending=1">
                    <span class="float-left">View Requests</span>
                    <span class="float-right">
                        <i class="fa fa-angle-right"></i>
                    </span>
                </a>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-warning o-hidden h-100">
                <div class="card-body">
                    <div class="card-body-icon">
                        <i class="fas fa-list"></i>
                    </div>
                    <div class="mr-5" style="">
                        Charts
                    </div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="{{ route('charts.index') }}">
                    <span class="float-left">View Charts</span>
                    <span class="float-right">
                        <i class="fa fa-angle-right"></i>
                    </span>
                </a>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-success o-hidden h-100">
                <div class="card-body">
                    <div class="card-body-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="mr-5" style="">
                        Bank
                    </div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="{{ route('bank.index') }}">
                    <span class="float-left">View Module</span>
                    <span class="float-right">
                        <i class="fa fa-angle-right"></i>
                    </span>
                </a>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-danger o-hidden h-100">
                <div class="card-body">
                    <div class="card-body-icon">
                        <i class="fas fa-life-ring"></i>
                    </div>
                    <div class="mr-5" style="">
                        Expenses
                    </div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="{{ route('expenses.index') }}">
                    <span class="float-left">View Module</span>
                    <span class="float-right">
                        <i class="fa fa-angle-right"></i>
                    </span>
                </a>
            </div>
        </div>
    </div>
    <div class="row">
            <div class="col-xl-3 col-sm-6 mb-3">
                <a class="btn btn-info btn-block" href="{{ route('payment_method.index') }}">Payment Methods</a>
            </div>
            <div class="col-xl-3 col-sm-6 mb-3">
                <a class="btn btn-info btn-block" href="{{ route('expenses.index') }}">Expenses</a>
            </div>
    </div>
</div>
@endsection
