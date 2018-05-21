<li class="nav-item">
    <a id="navbarDropdown" class="nav-link" href="{{ route('home') }}" role="button">
        Dashboard
    </a>
</li>

@if(\App\Checker::is_permitted('view charts'))
<li class="nav-item dropdown">
    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
        Charts <span class="caret"></span>
    </a>

    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
    @if(\App\Checker::is_permitted('view charts'))
        <a class="dropdown-item" href="{{ route('charts.index') }}">
            {{ __('Charts') }}
        </a>
    @endif
    @if(\App\Checker::is_permitted('create charts'))
        <a class="dropdown-item" href="{{ route('charts.create') }}">
            {{ __('Create Chart') }}
        </a>
    @endif
    </div>
</li>
@endif

{{-- @if(\App\Checker::is_permitted('view request_funds'))
<li class="nav-item dropdown">
    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
        Request Funds <span class="caret"></span>
    </a>

    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
    @if(\App\Checker::is_permitted('view charts'))
        <a class="dropdown-item" href="{{ route('request_funds.index') }}">
            {{ __('Requests') }}
        </a>
    @endif
    @if(\App\Checker::is_permitted('view charts'))
        <a class="dropdown-item" href="{{ route('request_funds.create') }}?multi=5">
            {{ __('Create Request') }}
        </a>
    @endif
    </div>
</li>
@endif --}}

@if(\App\Checker::is_permitted('view settings'))
<li class="nav-item dropdown">
    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
        Settings <span class="caret"></span>
    </a>

    <div class="dropdown-menu" aria-labelledby="navbarDropdown">   
    @if(\App\Checker::is_permitted('users'))
        <a class="dropdown-item" href="{{ route('users.index') }}">
            {{ __('Users') }}
        </a>
    @endif
    @if(\App\Checker::is_permitted('roles'))
        <a class="dropdown-item" href="{{ route('roles.index') }}">
            {{ __('Roles') }}
        </a>
    @endif
    </div>
</li>
@endif