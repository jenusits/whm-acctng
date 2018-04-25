@extends('layouts.app')

@section('content')

     <div class="container">
          <h2>Request a Fund</h2>
          @include('layouts.error-and-messages')
          <form method="post" action="{{route('charts.store')}}">
              @csrf
               <div class="row">
                    <div class="form-group col-md-4">
                         <label for="name">Particulars</label>
                         <textarea type="text" class="form-control" name="particulars">
                         </textarea>
                    </div>
                    <div class="form-group col-md-4">
                         <label for="name">Category</label>
                         <select name="category">
                              @foreach($categories as $category)
                                   <option value="{{ $category->id }}">{{ $category->account_name }}</option>
                              @endforeach
                         </select>
                    </div>
                    <div class="form-group col-md-4" style="margin-top:30px">
                         <button type="submit" class="btn btn-success">Submit Request</button>
                    </div>
                    <div class="col-md-4"></div>
               </div>
          </form>
     </div>

@endsection