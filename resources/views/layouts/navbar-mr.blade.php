<li class="nav-item">
    <a id="navbarDropdown" class="nav-link" href="{{ route('home') }}" role="button">
        Dashboard
    </a>
</li>

@if(\App\Checker::is_permitted('view expenses'))
<li class="nav-item dropdown">
    <a class="nav-link text-light" data-toggle="collapse" href="#expenses-menu-item" role="button" aria-expanded="false" aria-controls="expenses-menu-item">
        Expenses <i class="fa fa-caret-down"></i>
    </a>

    <div class="collapse bg-secondary" id="expenses-menu-item" aria-labelledby="navbarDropdown">
    @if(\App\Checker::is_permitted('view charts'))
        <a class="dropdown-item text-light" href="{{ route('expenses.index') }}">
            {{ __('Expenses') }}
        </a>
    @endif
    @if(\App\Checker::is_permitted('view charts'))
        <a class="dropdown-item text-light" href="{{ route('bill.create') }}">
            {{ __('Create Bill') }}
        </a>
    @endif
    @if(\App\Checker::is_permitted('view charts'))
        <a class="dropdown-item text-light" href="{{ route('expenses.create') }}">
            {{ __('Create Expense') }}
        </a>
    @endif
    @if(\App\Checker::is_permitted('create charts'))
        <a class="dropdown-item text-light" href="{{ route('check.create') }}">
            {{ __('Create Cheque') }}
        </a>
    @endif
    </div>
</li>
@endif

@if(\App\Checker::is_permitted('view charts'))
<li class="nav-item dropdown">
    {{-- <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
        Charts <span class="caret"></span>
    </a> --}}
    <a class="nav-link text-light" data-toggle="collapse" href="#charts-menu-item" role="button" aria-expanded="false" aria-controls="charts-menu-item">
        Charts <i class="fa fa-caret-down"></i>
    </a>
  

    <div class="collapse bg-secondary" id="charts-menu-item" aria-labelledby="navbarDropdown">
    @if(\App\Checker::is_permitted('view charts'))
    
        <a class="dropdown-item text-light" href="{{ route('charts.index') }}">
            {{ __('Charts') }}
        </a>
    @endif
    @if(\App\Checker::is_permitted('create charts'))
        <a class="dropdown-item text-light" href="{{ route('charts.create') }}">
            {{ __('Create Chart') }}
        </a>
    @endif
    </div>
</li>
@endif

@if(\App\Checker::is_permitted('view bank'))
<li class="nav-item dropdown">
    <a class="nav-link text-light" data-toggle="collapse" href="#bank-menu-item" role="button" aria-expanded="false" aria-controls="bank-menu-item">
        Banks <i class="fa fa-caret-down"></i>
    </a>
  

    <div class="collapse bg-secondary" id="bank-menu-item" aria-labelledby="navbarDropdown">
    @if(\App\Checker::is_permitted('view bank'))
    
        <a class="dropdown-item text-light" href="{{ route('bank.index') }}">
            {{ __('Banks') }}
        </a>
    @endif
    @if(\App\Checker::is_permitted('create bank'))
        <a class="dropdown-item text-light" href="{{ route('bank.create') }}">
            {{ __('Add Bank') }}
        </a>
    @endif
    </div>
</li>
@endif

@if(\App\Checker::is_permitted('view payee'))
<li class="nav-item dropdown">
    <a class="nav-link text-light" data-toggle="collapse" href="#payee-menu-item" role="button" aria-expanded="false" aria-controls="payee-menu-item">
        Payees <i class="fa fa-caret-down"></i>
    </a>
  

    <div class="collapse bg-secondary" id="payee-menu-item" aria-labelledby="navbarDropdown">
    @if(\App\Checker::is_permitted('view payee'))
    
        <a class="dropdown-item text-light" href="{{ route('payee.index') }}">
            {{ __('Payees') }}
        </a>
    @endif
    @if(\App\Checker::is_permitted('create payee'))
        <a class="dropdown-item text-light" href="{{ route('payee.create') }}">
            {{ __('Add Payee') }}
        </a>
    @endif
    </div>
</li>
@endif

@if(\App\Checker::is_permitted('view payment_method'))
<li class="nav-item dropdown">
    <a class="nav-link text-light" data-toggle="collapse" href="#payment_method-menu-item" role="button" aria-expanded="false" aria-controls="payment_method-menu-item">
        Payment Method <i class="fa fa-caret-down"></i>
    </a>
  

    <div class="collapse bg-secondary" id="payment_method-menu-item" aria-labelledby="navbarDropdown">
    @if(\App\Checker::is_permitted('view payment_method'))
    
        <a class="dropdown-item text-light" href="{{ route('payment_method.index') }}">
            {{ __('Payment Methods') }}
        </a>
    @endif
    @if(\App\Checker::is_permitted('create payment_method'))
        <a class="dropdown-item text-light" href="{{ route('payment_method.create') }}">
            {{ __('Add Payment Method') }}
        </a>
    @endif
    </div>
</li>
@endif

@if(\App\Checker::is_permitted('view settings'))
<li class="nav-item dropdown">
    <a class="nav-link text-light" data-toggle="collapse" href="#settings-menu-item" role="button" aria-expanded="false" aria-controls="settings-menu-item">
        Settings <i class="fa fa-caret-down"></i>
    </a>

    <div class="collapse bg-secondary" id="settings-menu-item" aria-labelledby="navbarDropdown">   
    @if(\App\Checker::is_permitted('users'))
        <a class="dropdown-item text-light" href="{{ route('users.index') }}">
            {{ __('Users') }}
        </a>
    @endif
    @if(\App\Checker::is_permitted('roles'))
        <a class="dropdown-item text-light" href="{{ route('roles.index') }}">
            {{ __('Roles') }}
        </a>
    @endif
    </div>
</li>
@endif
