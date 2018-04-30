<li class="nav-item">
    <a id="navbarDropdown" class="nav-link" href="{{ route('home') }}" role="button">
        Dashboard
    </a>
</li>

@if(\App\Checker::is_permitted('users'))
<li class="nav-item dropdown">
    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
        Users <span class="caret"></span>
    </a>

    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="{{ route('users.index') }}">
            {{ __('Users') }}
        </a>
    @if(\App\Checker::is_permitted('roles'))
        <a class="dropdown-item" href="{{ route('roles.index') }}">
            {{ __('Roles') }}
        </a>
    @endif
    
    @if(\App\Checker::is_permitted('permissions'))
        <a class="dropdown-item" href="{{ route('permissions.index') }}">
            {{ __('Permissions') }}
        </a>
    @endif
    </div>
</li>
@endif

<li class="nav-item dropdown">
    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
        Charts <span class="caret"></span>
    </a>

    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="{{ route('charts.index') }}">
            {{ __('Charts') }}
        </a>
        <a class="dropdown-item" href="{{ route('charts.create') }}">
            {{ __('Create Chart') }}
        </a>
    </div>
</li>

<li class="nav-item dropdown">
    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
        Request Funds <span class="caret"></span>
    </a>

    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="{{ route('request_funds.index') }}">
            {{ __('Requests') }}
        </a>
        <a class="dropdown-item" href="{{ route('request_funds.create') }}?multi=5">
            {{ __('Create Request') }}
        </a>
    </div>
</li>