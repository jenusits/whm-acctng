@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12 col-md-offset-1">
            @if(Auth::check())
                <a class="btn btn-success" href="{{ route('charts.create') }}">Create Chart</a>
            @endif
        </div>
    </div>
        <hr>
    <div class="row">
        <div class="col-md-12 col-md-offset-1">
            <div class="panel panel-success table-responsive">
                <div class="panel-heading">Chart of Accounts</div>
                @include('layouts.error-and-messages')
                @if(Auth::check())
                    <!-- Table -->
                    <table class="table table-sm table-transparent table-hover">
                        <tr>
                            <th>ID</th>
                            <th>Accounts</th>
                            <th></th>
                        </tr>
                        @foreach($charts as $key => $chart)
                            <tr>
                                <td>{{ $chart->id }}</td><td><a href="{{ route('charts.show', $chart->id) }}">{{ $chart->account_name }}</a></td>
                                <td>
                                    <a href="{{route('charts.edit', $chart->id)}}" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                    <form action="{{route('charts.destroy', $chart->id)}}" method="post" class="d-inline-block">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger" type="submit"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
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
</div>

@endsection