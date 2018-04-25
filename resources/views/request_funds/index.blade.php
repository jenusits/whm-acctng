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
                                </tr>
                                @foreach($request_funds as $key => $request_fund)
                                    <tr>
                                        <td>{{ $request_funds->id }}</td><td><a href="{{route('request_funds.show', $request_funds->id)}}">{{ $request_funds->account_name }}</a></td>
                                        <td><a href="{{route('request_funds.edit', $request_funds->id)}}" class="btn btn-warning">Edit</a></td>
                                        <td>
                                            <form action="{{route('request_funds.destroy', $request_funds->id)}}" method="post" class="d-inline-block">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-danger" type="submit">Delete</button>
                                            </form>
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