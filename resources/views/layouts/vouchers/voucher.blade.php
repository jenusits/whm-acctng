@extends('layouts.plain')

@section('content')
@if($expense->approved == 1)
<div class="container">
    <div class="row">
        <div class="col-md-12">
            {{-- IMAGE --}}
        </div>
    </div>

    <div class="row mb-4 border border-dark">
        <div class="col-auto mr-auto">
            <div class="row">
                <strong>
                    <span class="col-md-3" style="text-align: center;">
                        PAYEE: 
                    </span>
                    <span class="col-md-3" style="text-align: center;">
                        {{ \App\Payee::findOrFail($expense->payee)->name }}
                    </span>
                </strong>
            </div>
        </div>
        <div class="col-md-4 ml-md-auto">
            <div class="row"> Voucher </div>
            <div class="row"> Voucher #~ </div>
            {{-- <div class="row"> {{ \Carbon\Carbon::parse($expense->payment_date)->format('M d, Y') }} </div> --}}
            <div class="row"> {{ \Carbon\Carbon::now()->format('M d, Y') }} </div>
        </div>
    </div>

    <div class="row mb-4 border border-dark">
        <table class="table text-center">
            <thead>
                <th>Particulars</th>
                <th>Amount</th>
            </thead>
            <tbody>
                <?php $total = 0; ?>
                @foreach($particulars as $key => $particular)
                <?php $total += $particular->amount ?>
                <tr>
                    <td>{{ $particular->particulars }}</td>
                    <td>{{ $particular->amount }}</td>
                </tr>
                @endforeach
                <tr>
                    <td></td>
                    <td>
                        <strong>
                            {{-- Total --}}
                            {{ $total }}
                        </strong>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="row mb-4">
        <div class="col-md-6 border border-dark">
            <table class="table">   
                <thead>
                    <th>Account Title</th>
                    <th>Debit</th>
                    <th>Credit</th>
                    
                </thead>
                <tbody>
                    <?php $total = 0; ?>
                    @foreach($particulars as $key => $particular)
                    <?php $total += $particular->amount ?>
                    <tr>
                        <td>{{ $particular->particulars }}</td>
                        <td>{{ $particular->amount }}</td>
                        <td></td>
                    </tr>
                    @endforeach
                    <tr>
                        <td>{{ \App\Bank::find($expense->bank_credit_account)->name }}</td>
                        <td></td>
                        <td>{{ $total }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <strong>
                                {{-- Total --}}
                                {{ $total }}
                            </strong>
                        </td>
                        <td>
                            <strong>
                                {{-- Total --}}
                                {{ $total }}
                            </strong>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
        <div class="col-md-6 border border-dark">
            <div class="row">
                <strong>Amount in Words</strong>
                
                {{-- Bank Check No. --}}
            </div>
            <div class="row">
                Received by:

            </div>
        </div>
    </div>
    <div class="row mb-4 border border-dark">
        <div class="col-md-6">
            <div class="row">
                Prepared by:
            </div>
            <div class="row">   
                {{ \App\User::find($expense->author)->name }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                Approved by:
            </div>
            <div class="row">   
                {{ \App\User::find($expense->approved_by)->name }}
            </div>
        </div>
    </div>
</div>
@else
    Not yet approved.
@endif
@endsection