@extends('layouts.app')

@section('content')
<div id="root"></div>
    <div id="request-funds" >
        <div class="row">
            <div class="col-md-2 col-md-offset-1">
                @if(Auth::check())
                    <a href="{{ route('payment_method.create') }}" class="btn btn-success">Add new Payment method</a>
                @endif
            </div>
        </div>
        <hr>  
        <div class="row">
            <div class="col-md-12 col-md-offset-1">
                <div class="panel panel-success">
                    <div class="panel-heading">Payment Methods</div>
                    @include('layouts.error-and-messages')
                    @if(Auth::check())
    
                    <!-- Table -->
                    <table id="requests" class="table table-sm table-transparent table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                            @foreach($payment_methods as $key => $payment_method)
                            <tbody>
                                <tr>
                                    <td>
                                        <a class="link" href="{{ route('payment_method.show', $payment_method->id) }}">{{ $payment_method->name }}</a>
                                    </td>
                                    <td>{{ $payment_method->description }}</td>
                                    <td>
                                        @if(\App\Checker::is_permitted('update payment_method'))
                                            <a style="margin: 5px; font-size: 10px" href="{{ route('payment_method.edit', $payment_method->id) }}" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                        @endif
                                        @if(\App\Checker::is_permitted('delete payment_method'))
                                            <form id="form-{{ $payment_method->id }}" action="{{ route('payment_method.destroy', $payment_method->id) }}" method="post" class="d-inline-block">
                                                @csrf
                                                @method('delete')
                                                {{-- <button style="margin: 5px; font-size: 10px" class="btn btn-danger" type="submit"><i class="fas fa-trash"></i></button> --}}
                                                <button @click="focusedID = {{ $payment_method->id }}; chart_name = '{{ $payment_method->name }}'; reference_number = '#' + focusedID;" style="margin: 5px; font-size: 10px" type="button" class="btn btn-danger" data-toggle="modal" data-target=".app-modal"><i class="fas fa-trash"></i></button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                            @endforeach
                            <tr>
                            </tr>
                        </table>
                    @endif
                </div>
                    @if(Auth::guest())
                        <a href="/login" class="btn btn-info"> You need to login to see the list 😜😜 >></a>
                    @endif
            </div>
        </div>
        <b-modal id="app-modal" ref="requestfunds" @close="focusedID = 0" focusedID="focusedID" @confirm="deleteRequest" title="Confirm Action">
            Are you sure you want to delete <b>@{{ chart_name }}</b>?
        </b-modal>
    </div>
@endsection