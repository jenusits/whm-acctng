@extends('layouts.app')

@section('content')
<div id="root"></div>
    <div id="request-funds" class="container">
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
                                        <?php   
                                            $amount = DB::table('request_funds')
                                            ->join('request_funds_metas', 'request_funds.id', '=', 'request_funds_metas.request_funds_id')->where('request_funds_metas.request_funds_id', '=', $request_fund->id)
                                            ->sum('request_funds_metas.amount'); 
                                            echo $amount;
                                        ?>
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
                                    {{-- @if(Auth::id() == $request_fund->author || \App\Checker::is_permitted('request_funds')) --}}
                                        @if(Auth::id() == $request_fund->author || \App\Checker::is_permitted('update request_funds'))
                                            <a style="margin: 5px; font-size: 10px" href="{{ route('request_funds.edit', $request_fund->id) }}" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                        @endif
                                        @if(Auth::id() == $request_fund->author || \App\Checker::is_permitted('delete request_funds'))
                                            <form id="form-{{ $request_fund->id }}" action="{{ route('request_funds.destroy', $request_fund->id) }}" method="post" class="d-inline-block">
                                                @csrf
                                                @method('delete')
                                                {{-- <button style="margin: 5px; font-size: 10px" class="btn btn-danger" type="submit"><i class="fas fa-trash"></i></button> --}}
                                                <button @click="focusedID = {{ $request_fund->id }}; reference_number = '#' + focusedID;" style="margin: 5px; font-size: 10px" type="button" class="btn btn-danger" data-toggle="modal" data-target="#app-modal"><i class="fas fa-trash"></i></button>
                                            </form>
                                        @endif
                                    {{-- @endif --}}
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
        <b-modal @close="focusedID = 0" @confirm="deleteRequest" title="Confirm Action">
            Are you sure you want to delete Request with a reference number of <b>@{{ reference_number }}</b>?
        </b-modal>
    </div>
    @include('layouts.vuejs')
    <script>
        new Vue({
            el: '#request-funds',
            data: {
                focusedID: 0,
                reference_number: 0,
            },
            methods: {
                deleteRequest: function() {
                    var form = document.querySelector('#form-' + this.focusedID)
                    form.submit();
                    this.focusedID = 0;
                }
            }
        });
    </script>
@endsection