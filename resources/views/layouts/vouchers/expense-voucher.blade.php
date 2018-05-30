@extends('layouts.plain')

@section('content')
<style>
</style>

<div id="print-element" class="container">
    <div class="mt-5 company-information">
        <h2 class="company-title"><strong>{{ \Setting::get('company_name') }}</strong></h2>
        <div class="contact-information">
            <p>{{ \Setting::get('email_address') }}</p>
        </div>
    </div>
    
    <div class="mt-5">
        <div class="page-header mt-5">
            <h1>Expense Voucher</h1>
        </div>

        <div class="row  voucher-details p-5">
            <table style="width: 100%; max-width: 100%; margin: 0 auto">
                <tbody>
                    <tr style="font-size: 18px;">
                        <td class="text-left" style="width: 60%;">Payment To</td>
                        <td class="" style="width: 20%;">Date:</td>
                        <td class="" style="width: 20%;">{{ \Carbon\Carbon::parse($expense->getExpenseMeta('payment_date'))->format('m/d/Y') }}</td>
                    </tr>
                    <tr style="font-size: 18px;">
                        <td class="text-left" style="width: 60%;">{{ \App\Payee::find($expense->getExpenseMeta('payee'))->name }}</td>
                        <td class="" style="width: 20%;">Reference No:</td>
                        <td class="" style="width: 20%;">{{ $expense->id }}</td>
                        {{-- <td class="" style="width: 20%;">Payment Method:</td>
                        <td class="" style="width: 20%;">Cheque</td> --}}
                    </tr>
                    {{-- <tr style="font-size: 18px;">
                        <td class="" style="width: 60%;"></td>
                    </tr> --}}
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            <table class="table table-hover">
                <thead>
                    <tr style="font-size: 18px;">
                        <th class="text-left" scope="col">Account</th>
                        <th class="text-center" scope="col">Description</th>
                        <th class="text-right" scope="col">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $total_amount = 0; ?>
                    @foreach($expense->particulars as $key => $particular)
                    <?php $total_amount += $particular->amount ?>
                    <tr style="font-size: 18px;">
                        <td class="text-left">{{ \App\Charts::find($particular->category)->account_name }}</td>
                        <td class="text-center">{{ $particular->particulars }}</td>
                        <td class="text-right">{{ number_format((float) $particular->amount, 2, '.', '') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-5">
            <table class="table" style="border: 0px !important">
                <thead>
                    <tr style="font-size: 18px;">
                        <th style="border: 0px !important; padding: 0; width: 10%;" class="text-left" scope="col"></th>
                        <th style="border: 0px !important; padding: 0;" class="text-right" scope="col">TOTAL</th>
                        <th style="border: 0px !important; padding: 0;" class="text-right" scope="col">{{ \Setting::get('currency') }} {{ number_format((float) $total_amount, 2, '.', '') }}</th>
                    </tr>
                    <tr style="font-size: 18px;">
                        <th style="border: 0px !important; padding: 0; width: 10%;" class="text-left" scope="col"></th>
                        <th style="border: 0px !important; padding: 0;" class="text-right" scope="col">TOTAL DUE</th>
                        <th style="border: 0px !important; padding: 0;" class="text-right" scope="col"></th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="mt-5 border" style="font-size: 18px;">
            <p>
                Memo: {{ $expense->memo }}
            </p>
        </div>
    </div>
    <div class="row mt-5" style="font-size: 18px">   
        <div class="ml-auto mt-3">
            Signature:
        </div>
        <div class="ml-auto mt-3">
            ____________________________________________
        </div>
    </div>


        
</div>

<script src="{{ asset('js/printThis.js') }}"></script>
{{-- <button class="btn btn-success" onclick="window.JWSI.printDiv('print-element')">Print</button> --}}

@endsection