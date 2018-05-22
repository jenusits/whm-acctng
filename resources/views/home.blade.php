@extends('layouts.app')

@section('content')
<div >
    <div class="row">
       
        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-danger o-hidden h-100">
                <div class="card-body">
                    <div class="card-body-icon">
                        <i class="fas fa-money-bill-alt"></i>
                    </div>
                    <div class="mr-5" style="">
                        Expenses
                    </div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="{{ route('expenses.index') }}">
                    <span class="float-left">View Expenses</span>
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
                        <i class="fas fa-university"></i>
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
            <div class="card text-white bg-primary o-hidden h-100">
                <div class="card-body">
                    <div class="card-body-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="mr-5" style="">
                        Payee
                    </div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="{{ route('payee.index') }}">
                    <span class="float-left">View Payee</span>
                    <span class="float-right">
                        <i class="fa fa-angle-right"></i>
                    </span>
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-info o-hidden h-100">
                <div class="card-body">
                    <div class="card-body-icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <div class="mr-5" style="">
                        Payment Methods
                    </div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="{{ route('payment_method.index') }}">
                    <span class="float-left">View Payment Methods</span>
                    <span class="float-right">
                        <i class="fa fa-angle-right"></i>
                    </span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
