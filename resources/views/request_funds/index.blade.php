@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <a class="link" href="{{ route('request_funds.create') }}">Create a request</a>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Requests Created</div>
                    <div class="card-body">
                        @if(Auth::check())
                            <!-- Table -->
                            <table class="table">
                                <tr>
                                    <th>Particulars</th>
                                    <th>Accounts</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                @foreach($request_funds as $key => $request_fund)
                                    <tr>
                                        <td>{{ $request_fund->particulars }}</td>
                                        <td>
                                            {{-- <a href="{{route('requestd_funds.show', $request_fund->id)}}">{{ $request_fund->account_name }}</a> --}}
                                            {{ $charts->find($request_fund->id)->account_name }}
                                        </td>
                                        <td>
                                            @if($request_fund->approved)
                                                Approved
                                            @else
                                                Not approved
                                            @endif
                                        </td>
                                        <td>
                                            {{-- <a href="{{route('request_funds.edit', $request_fund->id)}}" class="btn btn-warning">Edit</a> --}}
                                        </td>
                                        <td>
                                            {{-- <form action="{{route('request_funds.destroy', $request_fund->id)}}" method="post" class="d-inline-block">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-danger" type="submit">Delete</button>
                                            </form> --}}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                </tr>
                            </table>
                        @endif                           
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection