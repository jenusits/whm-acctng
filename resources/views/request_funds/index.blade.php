@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12 col-md-offset-1">
                @if(Auth::check())
                    <a href="{{ route('request_funds.create') }}?multi=5" class="btn btn-success">Create a request</a>
                @endif
            </div>
        </div>
        <hr>  
        <div class="row">
            <div class="col-md-12 col-md-offset-1">
                <div class="panel panel-success">
                    <div class="panel-heading">Requests Created</div>
                    @include('layouts.error-and-messages')
                    @if(Auth::check())
    
                    <!-- Table -->
                    <table class="table table-sm table-transparent table-hover">
                            <tr>
                                <th>Reference #</th>
                                <th>Amount</th>
                                <th>Created</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            @foreach($request_funds as $key => $request_fund)
                                <tr>
                                    <td>
                                            {{-- {!! preg_replace('/<br\\s*?\/??>/i', '', $request_fund->particulars) !!} --}}
                                        <a class="link" href="{{ route('request_funds.show', $request_fund->id) }}">#{{ $request_fund->id }}</a>
                                    </td>
                                    <td>
                                        ASOIDJOIAS
                                    </td>
                                    <td>{{ $request_fund->created_at->diffForHumans() }}</td>
                                    <td>
                                        @if($request_fund->approved)
                                            Approved
                                        @else
                                            Pending
                                        @endif
                                    </td>
                                    <td>
                                        {{-- <a style="margin: 5px; font-size: 10px" href="{{ route('request_funds.show', $request_fund->id) }}" class="btn btn-success"><i class="fas fa-search"></i></a> --}}
                                        <a style="margin: 5px; font-size: 10px" href="{{route('request_funds.edit', $request_fund->id)}}" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                        <form action="{{route('request_funds.destroy', $request_fund->id)}}" method="post" class="d-inline-block">
                                            @csrf
                                            @method('delete')
                                            <button style="margin: 5px; font-size: 10px" class="btn btn-danger" type="submit"><i class="fas fa-trash"></i></button>
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