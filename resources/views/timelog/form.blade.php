@extends('layouts.timelog.plain')

@section('content')
    <div id="clock-container" class="flex-center position-ref full-height">
        <div class="content">   
            @include('layouts.error-and-messages')         
            <div id="clock" class="dark">
                <h2 style="margin: 0;">{{ \Carbon\Carbon::now()->format('M d, Y') }}</h2>
                <div class="display" style="height: auto;">
                    <div class="weekdays"></div>
                    <div class="ampm"></div>
                    <div class="alarm"></div>
                    <div class="digits"></div>
                </div>
            </div>

            <?php $emp = session()->get('employee'); ?>
            {{-- <div class="p-3 mt-3 bg-light text-dark">
                <p>Name: {{ $emp->meta('first_name') }} {{ $emp->meta('last_name') }}</p> 
                <p>Status: @if($emp->meta('login_status') == 1)<b class="text-success">Logged in</b>. @else <b class="text-danger">Logged off</b>. @endif </p>
                <p> 
                    @if($emp->meta('login_status') == 0)
                        @if($emp->last_timelog())
                            Logged out {{ \Carbon\Carbon::parse($emp->last_timelog()->logoff)->timezone(session('timezone'))->diffForHumans() }}
                        @else
                            Currently logged out.
                        @endif
                    @else
                        Logged in {{ \Carbon\Carbon::parse($emp->last_timelog()->login)->timezone(session('timezone'))->diffForHumans() }}
                    @endif
                </p>
            </div>
            
            @if($emp->meta('login_status') == 0)
            <form id="form-{{ $emp->id }}" action="{{ route('timelog.login') }}" method="POST" class="p-4">
            @else
            <form id="form-{{ $emp->id }}" action="{{ route('timelog.logoff') }}" method="POST" class="p-4">
            @endif
                @csrf
                <input type="hidden" name="tz" id="tz">
                <div class="form-group">
                    <input type="hidden" name="employee_id" value="{{ $emp->employee_id }}">
                    @if($emp->meta('login_status') == 0)
                        <button @click="focusedID = {{ $emp->id }}; type = 'Login';" type="button" class="btn btn-success btn-block mb-4" data-toggle="modal" data-target=".app-modal">Log in</button>
                    @else
                        <button @click="focusedID = {{ $emp->id }}; type = 'Log off';" type="button" class="btn btn-danger btn-block mb-4" data-toggle="modal" data-target=".app-modal">Log off</button>
                    @endif
                </div>
            </form> --}}
            
            <form v-on:submit.prevent="checkEmployeeId" action="{{ route('employees.check') }}" method="POST" class="p-4">
                @csrf
                <input type="hidden" name="tz" id="tz">
                <div class="form-group">
                    <input v-on:keyup="" v-model="employee_id" type="password" class="form-control text-center mb-4" name="employee_id" required placeholder="Enter Employee ID">
                    {{-- <button class="btn btn-success btn-block mb-4">Check</button> --}}
                    {{-- <button type="button" class="btn btn-primary btn-lg " id="load" data-loading-text="<i class='fas fa-circle-o-notch fa-spin'></i> Processing Order">
                        Submit Order
                    </button> --}}
                </div>
            </form>
            
            <button id="emp-message" style="display: none;" type="button" data-toggle="modal" data-target="#message"></button> 
            <b-modal id="message" ref="requestfunds" v-bind:title="message_title">
               @{{ message }}
            </b-modal>

            <button id="emp-login" style="display: none;" type="button" data-toggle="modal" data-target="#employee-login"></button> 
            <button id="emp-logoff" style="display: none;" type="button" data-toggle="modal" data-target="#employee-logoff"></button> 
                                          
            <b-modal id="employee-login" focusedID="focusedID" @confirm="employeeLogin" @close="employee_id = ''" confirm-text="Clock In" cancel-text="Cancel" title="">
                Currently logged off.
            </b-modal>
            <b-modal id="employee-logoff" focusedID="focusedID" @confirm="employeeLogoff" @close="employee_id = ''" confirm-text="Clock Out" cancel-text="Cancel" title="">
                Currently logged in.
            </b-modal>


        </div>
    </div>
    
    <div class="overlay">
        <div class="overlay-content">
            <div class="loader"></div>
        </div>
    </div>
    <script>
        $(function () {
            // guess user timezone 
            $('#tz').val(moment.tz.guess())
        });  
        
        var v = new Vue({
            el: '#clock-container',
            data: {
                focusedID: 0,
                type: '',
                employee_id: '',
                headers: {
                    'X-CSRF-Token': jQuery('meta[name=csrf-token]').attr('content'),
                },
                message: '',
                message_title: '',
            },
            methods: {
                confirmedAction: function() {
                    var form = document.querySelector('#form-' + this.focusedID)
                    form.submit();
                    this.focusedID = 0;
                },
                checkEmployeeId: function(e) {
                    // console.log(e);
                    jQuery('.overlay').toggleClass('show');
                    $.ajax({ 
                        url: '/employee/check',
                        type: 'GET',
                        beforeSend: function(xhr) {
                            xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'))
                        },
                        data: 'employee_id=' + this.employee_id,
                        success: function(response) {
                            // console.log(response);
                            setTimeout(function() { jQuery('.overlay').toggleClass('show'); }, 1000);
                            if (! response) {
                                v.message_title = "Employee not Found";
                                v.message = 'Employee ID does not exists.';
                                setTimeout(function() { jQuery('#emp-message').click(); }, 1000);
                            } else if (response.login_status == 0)
                                setTimeout(function() { jQuery('#emp-login').click(); }, 1000);
                            else if (response.login_status == 1)
                                setTimeout(function() { jQuery('#emp-logoff').click(); }, 1000);
                        }
                    });
                },
                employeeLogin: function() {
                    jQuery('.overlay').toggleClass('show');
                    $.ajax({ 
                        url: '/timelog/login',
                        type: 'POST',
                        beforeSend: function(xhr) {
                            xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'))
                        },
                        data: 'employee_id=' + this.employee_id,
                        success: function(response) {
                            // console.log(response);
                            v.employee_id = '';
                            setTimeout(function() { jQuery('.overlay').toggleClass('show'); }, 1000);
                            if (! response) {
                                v.message_title = "Error";
                                v.message = 'Please try again.';
                                setTimeout(function() { jQuery('#emp-message').click(); }, 1000);
                            } else {
                                v.message_title = "Success";
                                v.message = response.message;
                                setTimeout(function() { jQuery('#emp-message').click(); }, 1000);
                            }
                        }
                    });
                },
                employeeLogoff: function() {
                    jQuery('.overlay').toggleClass('show');
                    $.ajax({ 
                        url: '/timelog/logoff',
                        type: 'POST',
                        beforeSend: function(xhr) {
                            xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'))
                        },
                        data: 'employee_id=' + this.employee_id,
                        success: function(response) {
                            // console.log(response);
                            v.employee_id = '';
                            setTimeout(function() { jQuery('.overlay').toggleClass('show'); }, 1000);
                            if (! response) {
                                v.message_title = "Error";
                                v.message = 'Please try again.';
                                setTimeout(function() { jQuery('#emp-message').click(); }, 1000);
                            } else {
                                v.message_title = "Success";
                                v.message = response.message;
                                setTimeout(function() { jQuery('#emp-message').click(); }, 1000);
                            }
                        }
                    });
                }
            }
        });
    </script>

    <style>
        /* The Overlay (background) */
        .overlay {
            /* Height & width depends on how you want to reveal the overlay (see JS below) */    
            height: 100%;
            width: 0;
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            background-color: rgb(0,0,0); /* Black fallback color */
            background-color: rgba(0,0,0, 0.9); /* Black w/opacity */
            overflow-x: hidden; /* Disable horizontal scroll */
            transition: 0.5s; /* 0.5 second transition effect to slide in or slide down the overlay (height or width, depending on reveal) */
        }

        .overlay.show {
            width: 100%;
        }

        /* Position the content inside the overlay */
        .overlay-content {
            position: relative;
            top: 35%; /* 25% from the top */
            width: 100%; /* 100% width */
            text-align: center; /* Centered text/links */
            margin-top: 30px; /* 30px top margin to avoid conflict with the close button on smaller screens */
        }

        .loader {
            margin: 0 auto;
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #3498db;
            width: 120px;
            height: 120px;
            -webkit-animation: spin 2s linear infinite; /* Safari */
            animation: spin 2s linear infinite;
        }
        
        /* Safari */
        @-webkit-keyframes spin {
            0% { -webkit-transform: rotate(0deg); }
            100% { -webkit-transform: rotate(360deg); }
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        /*-------------------------
            Simple reset
        --------------------------*/
        
        
        *{
            margin:0;
            padding:0;
        }
        
        
        /*-------------------------
            General Styles
        --------------------------*/
        
        
        html{
            /* background:url('../img/bg.jpg') #dbe4e6; */
            overflow:hidden;
        }
        
        body{
            font:15px/1.3 Arial, sans-serif;
            color: #4f4f4f;
            z-index:1;
        }
        
        a, a:visited {
            outline:none;
            color:#389dc1;
        }
        
        a:hover{
            text-decoration:none;
        }
        
        section, footer, header, aside{
            display: block;
        }
        
        
        /*-------------------------
            The clocks
        --------------------------*/
        
        
        #clock{
            width:370px;
            /* padding:40px; */
            /* margin:200px auto 60px; */
            position:relative;
        }
        
        #clock:after{
            content:'';
            position:absolute;
            width:400px;
            height:20px;
            border-radius:100%;
            left:50%;
            margin-left:-200px;
            bottom:2px;
            z-index:-1;
        }
        
        
        #clock .display{
            text-align:center;
            padding: 40px 20px 20px;
            border-radius:6px;
            position:relative;
            height: 54px;
        }
        
        
        /*-------------------------
            Light color theme
        --------------------------*/
        
        
        #clock.light{
            background-color:#f3f3f3;
            color:#272e38;
        }
        
        #clock.light:after{
            box-shadow:0 4px 10px rgba(0,0,0,0.15);
        }
        
        #clock.light .digits div span{
            background-color:#272e38;
            border-color:#272e38;	
        }
        
        #clock.light .digits div.dots:before,
        #clock.light .digits div.dots:after{
            background-color:#272e38;
        }
        
        #clock.light .alarm{
            /* background:url('../img/alarm_light.jpg'); */
        }
        
        #clock.light .display{
            background-color:#dddddd;
            box-shadow:0 1px 1px rgba(0,0,0,0.08) inset, 0 1px 1px #fafafa;
        }
        
        
        /*-------------------------
            Dark color theme
        --------------------------*/
        
        
        #clock.dark{
            background-color:#272e38;
            color:#cacaca;
        }
        
        #clock.dark:after{
            box-shadow:0 4px 10px rgba(0,0,0,0.3);
        }
        
        #clock.dark .digits div span{
            background-color:#cacaca;
            border-color:#cacaca;	
        }
        
        #clock.dark .alarm{
            /* background:url('../img/alarm_dark.jpg'); */
        }
        
        #clock.dark .display{
            background-color:#0f1620;
            box-shadow:0 1px 1px rgba(0,0,0,0.08) inset, 0 1px 1px #2d3642;
        }
        
        #clock.dark .digits div.dots:before,
        #clock.dark .digits div.dots:after{
            background-color:#cacaca;
        }
        
        
        /*-------------------------
            The Digits
        --------------------------*/
        
        
        #clock .digits div{
            text-align:left;
            position:relative;
            width: 28px;
            height:50px;
            display:inline-block;
            margin:0 4px;
        }
        
        #clock .digits div span{
            opacity:0;
            position:absolute;
        
            -webkit-transition:0.25s;
            -moz-transition:0.25s;
            transition:0.25s;
        }
        
        #clock .digits div span:before,
        #clock .digits div span:after{
            content:'';
            position:absolute;
            width:0;
            height:0;
            border:5px solid transparent;
        }
        
        #clock .digits .d1{			height:5px;width:16px;top:0;left:6px;}
        #clock .digits .d1:before{	border-width:0 5px 5px 0;border-right-color:inherit;left:-5px;}
        #clock .digits .d1:after{	border-width:0 0 5px 5px;border-left-color:inherit;right:-5px;}
        
        #clock .digits .d2{			height:5px;width:16px;top:24px;left:6px;}
        #clock .digits .d2:before{	border-width:3px 4px 2px;border-right-color:inherit;left:-8px;}
        #clock .digits .d2:after{	border-width:3px 4px 2px;border-left-color:inherit;right:-8px;}
        
        #clock .digits .d3{			height:5px;width:16px;top:48px;left:6px;}
        #clock .digits .d3:before{	border-width:5px 5px 0 0;border-right-color:inherit;left:-5px;}
        #clock .digits .d3:after{	border-width:5px 0 0 5px;border-left-color:inherit;right:-5px;}
        
        #clock .digits .d4{			width:5px;height:14px;top:7px;left:0;}
        #clock .digits .d4:before{	border-width:0 5px 5px 0;border-bottom-color:inherit;top:-5px;}
        #clock .digits .d4:after{	border-width:0 0 5px 5px;border-left-color:inherit;bottom:-5px;}
        
        #clock .digits .d5{			width:5px;height:14px;top:7px;right:0;}
        #clock .digits .d5:before{	border-width:0 0 5px 5px;border-bottom-color:inherit;top:-5px;}
        #clock .digits .d5:after{	border-width:5px 0 0 5px;border-top-color:inherit;bottom:-5px;}
        
        #clock .digits .d6{			width:5px;height:14px;top:32px;left:0;}
        #clock .digits .d6:before{	border-width:0 5px 5px 0;border-bottom-color:inherit;top:-5px;}
        #clock .digits .d6:after{	border-width:0 0 5px 5px;border-left-color:inherit;bottom:-5px;}
        
        #clock .digits .d7{			width:5px;height:14px;top:32px;right:0;}
        #clock .digits .d7:before{	border-width:0 0 5px 5px;border-bottom-color:inherit;top:-5px;}
        #clock .digits .d7:after{	border-width:5px 0 0 5px;border-top-color:inherit;bottom:-5px;}
        
        
        /* 1 */
        
        #clock .digits div.one .d5,
        #clock .digits div.one .d7{
            opacity:1;
        }
        
        /* 2 */
        
        #clock .digits div.two .d1,
        #clock .digits div.two .d5,
        #clock .digits div.two .d2,
        #clock .digits div.two .d6,
        #clock .digits div.two .d3{
            opacity:1;
        }
        
        /* 3 */
        
        #clock .digits div.three .d1,
        #clock .digits div.three .d5,
        #clock .digits div.three .d2,
        #clock .digits div.three .d7,
        #clock .digits div.three .d3{
            opacity:1;
        }
        
        /* 4 */
        
        #clock .digits div.four .d5,
        #clock .digits div.four .d2,
        #clock .digits div.four .d4,
        #clock .digits div.four .d7{
            opacity:1;
        }
        
        /* 5 */
        
        #clock .digits div.five .d1,
        #clock .digits div.five .d2,
        #clock .digits div.five .d4,
        #clock .digits div.five .d3,
        #clock .digits div.five .d7{
            opacity:1;
        }
        
        /* 6 */
        
        #clock .digits div.six .d1,
        #clock .digits div.six .d2,
        #clock .digits div.six .d4,
        #clock .digits div.six .d3,
        #clock .digits div.six .d6,
        #clock .digits div.six .d7{
            opacity:1;
        }
        
        
        /* 7 */
        
        #clock .digits div.seven .d1,
        #clock .digits div.seven .d5,
        #clock .digits div.seven .d7{
            opacity:1;
        }
        
        /* 8 */
        
        #clock .digits div.eight .d1,
        #clock .digits div.eight .d2,
        #clock .digits div.eight .d3,
        #clock .digits div.eight .d4,
        #clock .digits div.eight .d5,
        #clock .digits div.eight .d6,
        #clock .digits div.eight .d7{
            opacity:1;
        }
        
        /* 9 */
        
        #clock .digits div.nine .d1,
        #clock .digits div.nine .d2,
        #clock .digits div.nine .d3,
        #clock .digits div.nine .d4,
        #clock .digits div.nine .d5,
        #clock .digits div.nine .d7{
            opacity:1;
        }
        
        /* 0 */
        
        #clock .digits div.zero .d1,
        #clock .digits div.zero .d3,
        #clock .digits div.zero .d4,
        #clock .digits div.zero .d5,
        #clock .digits div.zero .d6,
        #clock .digits div.zero .d7{
            opacity:1;
        }
        
        
        /* The dots */
        
        #clock .digits div.dots{
            width:5px;
        }
        
        #clock .digits div.dots:before,
        #clock .digits div.dots:after{
            width:5px;
            height:5px;
            content:'';
            position:absolute;
            left:0;
            top:14px;
        }
        
        #clock .digits div.dots:after{
            top:34px;
        }
        
        
        /*-------------------------
            The Alarm
        --------------------------*/
        
        
        #clock .alarm{
            width:16px;
            height:16px;
            bottom:20px;
            /* background:url('../img/alarm_light.jpg'); */
            position:absolute;
            opacity:0.2;
        }
        
        #clock .alarm.active{
            opacity:1;
        }
        
        
        /*-------------------------
            Weekdays
        --------------------------*/
        
        
        #clock .weekdays{
            font-size:12px;
            position:absolute;
            width:100%;
            top:10px;
            left:0;
            text-align:center;
        }
        
        
        #clock .weekdays span{
            opacity:0.2;
            padding:0 10px;
        }
        
        #clock .weekdays span.active{
            opacity:1;
        }
        
        
        /*-------------------------
                AM/PM
        --------------------------*/
        
        
        #clock .ampm{
            position:absolute;
            bottom:20px;
            right:20px;
            font-size:12px;
        }
        
        
        /*-------------------------
                Button
        --------------------------*/
        
        
        .button-holder{
            text-align:center;
            padding-bottom:100px;
        }
        
        a.button{
            background-color:#f6a7b3;
            
            background-image:-webkit-linear-gradient(top, #f6a7b3, #f0a3af);
            background-image:-moz-linear-gradient(top, #f6a7b3, #f0a3af);
            background-image:linear-gradient(top, #f6a7b3, #f0a3af);
        
            border:1px solid #eb9ba7;
            border-radius:2px;
        
            box-shadow:0 2px 2px #ccc;
        
            color:#fff;
            text-decoration: none !important;
            padding:15px 20px;
            display:inline-block;
            cursor:pointer;
        }
        
        a.button:hover{
            opacity:0.9;
        }
        
        
        /*----------------------------
            The Demo Footer
        -----------------------------*/
        
        
        footer{
        
            width: 770px;
            font: normal 16px Arial, Helvetica, sans-serif;
            padding: 15px 35px;
            position: fixed;
            bottom: 0;
            left: 50%;
            margin-left: -420px;
        
            background-color:#1f1f1f;
        
            background-image:-webkit-linear-gradient(top, #1f1f1f, #101010);
            background-image:-moz-linear-gradient(top, #1f1f1f, #101010);
            background-image:linear-gradient(top, #1f1f1f, #101010);
        
            border-radius:2px 2px 0 0;
        
            box-shadow: 0 -1px 4px rgba(0,0,0,0.4);
            z-index:1;
        }
        
        footer a.tz{
            font-weight:normal;
            font-size:16px !important;
            text-decoration:none !important;
            display:block;
            margin-right: 300px;
            text-overflow:ellipsis;
            white-space: nowrap;
            color:#bfbfbf !important;
            z-index:1;
        }
        
        footer a.tz:before{
            content: '';
            /* background: url('http://cdn.tutorialzine.com/misc/enhance/v2_footer_bg.png') no-repeat 0 -53px; */
            width: 138px;
            height: 20px;
            display: inline-block;
            position: relative;
            bottom: -3px;
        }
        
        footer .close{
            position: absolute;
            cursor: pointer;
            width: 8px;
            height: 8px;
            /* background: url('http://cdn.tutorialzine.com/misc/enhance/v2_footer_bg.png') no-repeat 0 0px; */
            top:10px;
            right:10px;
            z-index: 3;
        }
        
        footer #tzine-actions{
            position: absolute;
            top: 8px;
            width: 500px;
            right: 50%;
            margin-right: -650px;
            text-align: right;
            z-index: 2;
        }
        
        footer #tzine-actions iframe{
            display: inline-block;
            height: 21px;
            width: 95px;
            position: relative;
            float: left;
            margin-top: 11px;
        }
    </style>
@endsection