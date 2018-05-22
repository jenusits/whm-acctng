@extends('layouts.app')

@section('content')
<div id="root"></div>
    <div id="chart" >
        <div class="row">
            <div class="col-md-12 col-md-offset-1">
                <div class="panel panel-success">
                    <div class="panel-heading">Chart of Accounts</div>
                @include('layouts.error-and-messages')  
                @if(Auth::check())
                    <!-- Table -->
                        <table class="table">
                            <tr>
                                <th>ID</th>
                                <td colspan="2">{{ $chart->id }}</td>
                            </tr>
                            <tr>
                                    <th>Accounts</th>
                                    <td colspan="2">{{ $chart->account_name }}</td>
                            </tr>
                            <tr>
                                <th>Actions</th>
                                <td><a href="{{route('charts.edit', $chart->id)}}" class="btn btn-warning">Edit</a></td>
                                <td>
                                    <form id="form-{{ $chart->id }}" action="{{route('charts.destroy', $chart->id)}}" method="post" class="d-inline-block">
                                        @csrf
                                        @method('delete')
                                        {{-- <button class="btn btn-danger" type="submit">Delete</button> --}}
                                        <button @click="focusedID = {{ $chart->id }}; chart_name = '{{ $chart->account_name }}';" type="button" class="btn btn-danger" data-toggle="modal" data-target="#app-modal">Delete</button> 
                                    </form>
                                    </td>
                                </tr>
                            <tr>

                            </tr>
                        </table>
                    @endif


                </div>
                @if(Auth::guest())
                <a href="{{ route('login') }}" class="btn btn-info"> You need to login to see the list 😜😜 >></a>
                @endif
            </div>
        </div>

        <b-modal id="app-modal" @close="focusedID = 0" @confirm="deleteChart" title="Confirm Action">
            Are you sure you want to delete Request with a reference number of <b>@{{ chart_name }}</b>?
        </b-modal>
    </div>
    @include('layouts.vuejs')
    <script>
        new Vue({
            el: '#chart',
            data: {
                focusedID: 0,
                chart_name: 0,
            },
            methods: {
                deleteChart: function() {
                    var form = document.querySelector('#form-' + this.focusedID)
                    form.submit();
                    this.focusedID = 0;
                }
            }
        });
    </script>
@endsection