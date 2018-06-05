<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    {{-- <meta http-equiv="X-UA-Compatible" content="IE=edge"> --}}
    <meta id="_token" value="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->

    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="https://fonts.gstatic.com"> --}}
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/fontawesome-all.min.css') }}" rel="stylesheet" type="text/css">


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <div id="wrapper" class="@auth toggled @endauth"> 
            <!-- Sidebar -->
            @auth
            <div id="sidebar-wrapper">
                <ul class="sidebar-nav">
                    <li class="nav-item">
                        <a class="container text-center nav-link" href="{{ url('/home') }}">
                            {{ config('app.name', 'Laravel') }}
                        </a>
                        <div id="close-menu-container" style="position: absolute; top: 0; right: 0;">
                            <button class="btn text-white" style="background: transparent" id="close-menu"><i class="fa fa-times"></i></button>
                        </div>
                    </li>
                    
                    @auth
                        @include('layouts.navbar-mr')
                    @endauth
                </ul>
            </div>
            @endauth
            <!-- /#sidebar-wrapper -->
            
                <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
                    @auth
                        <a href="#menu-toggle" class="btn text-dark btn-lg" id="menu-toggle"><i class="fa fa-bars"></i></a>
                    @endauth
                    <!-- Left Side Of Navbar -->
                    @guest
                    <a class="nav-link container" href="{{ url('/home') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                    @endguest
                    
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto col-md-2" style="width: auto">
                        <!-- Authentication Links -->
                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('timelog') }}">
                                Time Log
                            </a>
                        </li>
                        @else
                            {{-- @include('layouts.navbar-ml') --}}
                            <li class="nav-item dropdown container">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"  aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu">
                                    @include('layouts.navbar-dropdown')
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                        </ul>
                </nav>
            <div id="page-content-wrapper"> 
                <main class="container-fluid">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/jwsi.js') }}"></script>
    <script src="{{ asset('js/jquery-functions.js') }}"></script>
</body>
</html>
