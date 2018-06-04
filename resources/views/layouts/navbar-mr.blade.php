<?php
    $route = \Route::currentRouteName();
    // $module = explode('.', \Route::currentRouteName())[0];
    // $view = explode('.', \Route::currentRouteName())[1];
    function strposa($haystack, $needle, $offset = 0) {
        if(!is_array($needle)) $needle = array($needle);
        foreach($needle as $query) {
            if(strpos($haystack, $query, $offset) !== false) return true; // stop on first true result
        }
        return false;
    }
    function check_current($v) {
        $route = \Route::currentRouteName();
        return $route == $v;
    }
?>
<li class="nav-item">
    <a class="nav-link @if(check_current('home')) bg-secondary text-white @endif" href="{{ route('home') }}" role="button">
        Dashboard
    </a>
</li>

{{-- Expenses --}}
@if(PermissionChecker::is_permitted('view expenses'))
<li class="nav-item dropdown">
    
    <a class="nav-link @if(check_current('expenses.index')) bg-secondary text-white @endif" href="{{ route('expenses.index') }}" role="button">
        Expenses
        <div class="float-right caret-down-icon">
            <span class="badge badge-warning badge-pill pending-expenses" title="{{ \DB::table('expenses')->where('approved', '=', '0')->count() }} Pending" data-toggle="tooltip" data-placement="left">
                {{ \DB::table('expenses')->where('approved', '=', '0')->count() > 0 ? \DB::table('expenses')->where('approved', '=', '0')->count() : '' }}
            </span>
        </div>
    </a>
    {{-- <a class="nav-link dropdown-parent" href="{{ route('expenses.index') }}" href="#expenses-menu-item" role="button" aria-expanded="false" aria-controls="expenses-menu-item">
        Expenses <div class="float-right caret-down-icon"><span class="badge badge-warning badge-pill">14</span><i class="fa fa-caret-down"></i></div>
    </a> --}}

    {{-- @if(strposa($route, ['bill', 'expenses', 'check']))
        <div class="collapse bg-secondary show" id="expenses-menu-item" aria-labelledby="navbarDropdown">
    @else
        <div class="collapse bg-secondary" id="expenses-menu-item" aria-labelledby="navbarDropdown">
    @endif
    @if(PermissionChecker::is_permitted('view expenses'))
        <a class="dropdown-item text-light @if(check_current('expenses.index')) active @endif" href="{{ route('expenses.index') }}">
            {{ __('Expenses') }}
        </a>
    @endif
    @if(PermissionChecker::is_permitted('view bill'))
        <a class="dropdown-item text-light @if(check_current('bill.create')) active @endif" href="{{ route('bill.create') }}">
            {{ __('Create Bill') }}
        </a>
    @endif
    @if(PermissionChecker::is_permitted('view expenses'))
        <a class="dropdown-item text-light @if(check_current('expenses.create')) active @endif" href="{{ route('expenses.create') }}">
            {{ __('Create Expense') }}
        </a>
    @endif
    @if(PermissionChecker::is_permitted('create check'))
        <a class="dropdown-item text-light @if(check_current('check.create')) active @endif" href="{{ route('check.create') }}">
            {{ __('Create Cheque') }}
        </a>
    @endif
    </div> --}}
</li>
@endif

{{-- Pay Bills --}}
@if(PermissionChecker::is_permitted('view charts'))
<li class="nav-item dropdown">
    <a class="nav-link @if(check_current('pay-bills.index')) bg-secondary text-white @endif" href="{{ route('pay-bills.index') }}" role="button">
        Pay Bills
    </a>
</li>
@endif

{{-- Charts --}}
@if(PermissionChecker::is_permitted('view charts'))
<li class="nav-item dropdown">
    <a class="nav-link dropdown-parent" {{-- data-toggle="collapse" --}} href="#charts-menu-item" role="button" aria-expanded="false" aria-controls="charts-menu-item">
        Charts <div class="float-right caret-down-icon"><i class="fa fa-caret-down"></i></div>
    </a>
    
    @if(strposa($route, ['charts']))
        <div class="collapse bg-secondary show" id="charts-menu-item" aria-labelledby="navbarDropdown">
    @else
        <div class="collapse bg-secondary" id="charts-menu-item" aria-labelledby="navbarDropdown">
    @endif
    @if(PermissionChecker::is_permitted('view charts'))
    
        <a class="dropdown-item text-light @if(check_current('charts.index')) active @endif" href="{{ route('charts.index') }}">
            {{ __('Charts') }}
        </a>
    @endif
    @if(PermissionChecker::is_permitted('create charts'))
        <a class="dropdown-item text-light @if(check_current('charts.create')) active @endif" href="{{ route('charts.create') }}">
            {{ __('Create Chart') }}
        </a>
    @endif
    </div>
</li>
@endif

{{-- Payee --}}
@if(PermissionChecker::is_permitted('view bank'))
<li class="nav-item dropdown">
    <a class="nav-link dropdown-parent" {{-- data-toggle="collapse" --}} href="#bank-menu-item" role="button" aria-expanded="false" aria-controls="bank-menu-item">
        Banks <div class="float-right caret-down-icon"><i class="fa fa-caret-down"></i></div>
    </a>

    @if(strposa($route, ['bank']))
        <div class="collapse bg-secondary show" id="bank-menu-item" aria-labelledby="navbarDropdown">
    @else
        <div class="collapse bg-secondary" id="bank-menu-item" aria-labelledby="navbarDropdown">
    @endif
    @if(PermissionChecker::is_permitted('view bank'))
    
        <a class="dropdown-item text-light @if(check_current('bank.index')) active @endif" href="{{ route('bank.index') }}">
            {{ __('Banks') }}
        </a>
    @endif
    @if(PermissionChecker::is_permitted('create bank'))
        <a class="dropdown-item text-light @if(check_current('bank.create')) active @endif" href="{{ route('bank.create') }}">
            {{ __('Add Bank') }}
        </a>
    @endif
    </div>
</li>
@endif

{{-- Payee  --}}
@if(PermissionChecker::is_permitted('view payee'))
<li class="nav-item dropdown">
    <a class="nav-link dropdown-parent" {{-- data-toggle="collapse" --}} href="#payee-menu-item" role="button" aria-expanded="false" aria-controls="payee-menu-item">
        Payees <div class="float-right caret-down-icon"><i class="fa fa-caret-down"></i></div>
    </a>

    @if(strposa($route, ['payee']))
        <div class="collapse bg-secondary show" id="payee-menu-item" aria-labelledby="navbarDropdown">
    @else
        <div class="collapse bg-secondary" id="payee-menu-item" aria-labelledby="navbarDropdown">
    @endif
    @if(PermissionChecker::is_permitted('view payee'))
        <a class="dropdown-item text-light @if(check_current('payee.index')) active @endif" href="{{ route('payee.index') }}">
            {{ __('Payees') }}
        </a>
    @endif
    @if(PermissionChecker::is_permitted('create payee'))
        <a class="dropdown-item text-light @if(check_current('payee.create')) active @endif" href="{{ route('payee.create') }}">
            {{ __('Add Payee') }}
        </a>
    @endif
    </div>
</li>
@endif

{{-- Payment Method  --}}
@if(PermissionChecker::is_permitted('view payment_method'))
<li class="nav-item dropdown">
    <a class="nav-link dropdown-parent" {{-- data-toggle="collapse" --}} href="#payment_method-menu-item" role="button" aria-expanded="false" aria-controls="payment_method-menu-item">
        Payment Method <div class="float-right caret-down-icon"><i class="fa fa-caret-down"></i></div>
    </a>
    @if(strposa($route, ['payment_method']))
        <div class="collapse bg-secondary show" id="payment_method-menu-item" aria-labelledby="navbarDropdown">
    @else
        <div class="collapse bg-secondary" id="payment_method-menu-item" aria-labelledby="navbarDropdown">
    @endif
    @if(PermissionChecker::is_permitted('view payment_method'))
        <a class="dropdown-item text-light @if(check_current('payment_method.index')) active @endif" href="{{ route('payment_method.index') }}">
            {{ __('Payment Methods') }}
        </a>
    @endif
    @if(PermissionChecker::is_permitted('create payment_method'))
        <a class="dropdown-item text-light @if(check_current('payment_method.create')) active @endif" href="{{ route('payment_method.create') }}">
            {{ __('Add Payment Method') }}
        </a>
    @endif
    </div>
</li>
@endif

{{-- Employees  --}}
@if(PermissionChecker::is_permitted('view employees'))
<li class="nav-item dropdown">
    <a class="nav-link dropdown-parent" {{-- data-toggle="collapse" --}} href="#employees-menu-item" role="button" aria-expanded="false" aria-controls="employees-menu-item">
        Employees <div class="float-right caret-down-icon"><i class="fa fa-caret-down"></i></div>
    </a>
    @if(strposa($route, ['employees']))
        <div class="collapse bg-secondary show" id="employees-menu-item" aria-labelledby="navbarDropdown">
    @else
        <div class="collapse bg-secondary" id="employees-menu-item" aria-labelledby="navbarDropdown">
    @endif
    @if(PermissionChecker::is_permitted('view employees'))
        <a class="dropdown-item text-light @if(check_current('employees.index')) active @endif" href="{{ route('employees.index') }}">
            {{ __('Employees') }}
        </a>
    @endif
    @if(PermissionChecker::is_permitted('create employees'))
        <a class="dropdown-item text-light @if(check_current('employees.create')) active @endif" href="{{ route('employees.create') }}">
            {{ __('Add Employee') }}
        </a>
    @endif
    </div>
</li>
@endif

{{-- Settings --}}
@if(PermissionChecker::is_permitted('view settings'))
<div class="dropdown-divider border-light"></div>
<li class="nav-item dropdown">
    <a class="nav-link dropdown-parent" {{-- data-toggle="collapse" --}} href="#settings-menu-item" role="button" aria-expanded="false" aria-controls="settings-menu-item">
        Settings <div class="float-right caret-down-icon"><i class="fa fa-caret-down"></i></div>
    </a>

    @if(strposa($route, ['users', 'roles', 'settings']))
        <div class="collapse bg-secondary show" id="settings-menu-item" aria-labelledby="navbarDropdown">
    @else
        <div class="collapse bg-secondary" id="settings-menu-item" aria-labelledby="navbarDropdown">
    @endif  
    @if(PermissionChecker::is_permitted('view settings'))
        <a class="dropdown-item text-light @if(check_current('settings.index')) active @endif" href="{{ route('settings.index') }}">
            {{ __('General') }}
        </a>
    @endif
    @if(PermissionChecker::is_permitted('users'))
        <a class="dropdown-item text-light @if(check_current('users.index')) active @endif" href="{{ route('users.index') }}">
            {{ __('Users') }}
        </a>
    @endif
    @if(PermissionChecker::is_permitted('roles'))
        <a class="dropdown-item text-light @if(check_current('roles.index')) active @endif" href="{{ route('roles.index') }}">
            {{ __('Roles') }}
        </a>
    @endif
    </div>
</li>
@endif
