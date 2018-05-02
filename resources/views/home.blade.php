@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div style="margin: 10px 0" class="col-md-12">
                <div class="card">
                    <div class="card-header">Charts</div>
    
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        Pariatur laboris aute id aliqua aute commodo cupidatat nisi voluptate. Ad enim magna officia eu sunt amet excepteur et mollit quis duis dolor occaecat. Labore officia esse dolore enim consequat magna eu. Aliqua do excepteur aliquip magna laborum velit laborum amet tempor incididunt consequat ipsum.
                    </div>
                </div>
        </div>
        <div style="margin: 10px 0" class="col-md-12 ">
                <div class="card">
                    <div class="card-header">Request Funds</div>
    
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        Dolor occaecat do amet laborum eiusmod. Quis et ullamco Lorem minim laborum cillum. Nisi laborum esse esse tempor eiusmod eiusmod occaecat ut officia enim. Magna dolore consequat esse excepteur ad ad nostrud fugiat. Esse Lorem do id occaecat duis officia deserunt labore labore aliqua velit.
                    </div>
                </div>
        </div>
        <div style="margin: 10px 0" class="col-md-12">
                <div class="card">
                    <div class="card-header">Dashboard</div>
    
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
    
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection
