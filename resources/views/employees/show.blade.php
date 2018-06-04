@extends('layouts.app')

@section('content')

     <div class="container">
          <div class="row">
               <div class="col-md-3">
                    <h3>{{ $employee->meta('first_name') }} {{ $employee->meta('last_name') }}</h3>
               </div>
          </div>
          
          <table class="table text-center">
               <thead>
                    <tr>
                         <th>Log In</th>
                         <th>Log Out</th>
                         <th>Duration</th>
                    </tr>
               </thead>
               <tbody>
               @foreach($employee->timelogs as $key => $timelog)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($timelog->login)->format('H:i M d Y') }}</td>
                        <td>
                            @if($timelog->logoff)
                                {{ \Carbon\Carbon::parse($timelog->logoff)->format('H:i M d Y') }}
                            @else  
                                Currently logged in
                            @endif
                        </td>
                        <td>
                            @if($timelog->logoff)
                                <?php 
                                    $end_time = \Carbon\Carbon::parse($timelog->logoff); 
                                    $start_time = \Carbon\Carbon::parse($timelog->login); 
                                    $duration = $end_time->diffInSeconds($start_time);
                                ?>
                                {{ gmdate('H:i:s', $duration) }}
                            @else  
                                    Currently logged in
                            @endif
                        </td>
                    </tr>
               @endforeach
               </tbody>
          </table>
     </div>

@endsection