@if(env('APP_ENV') == 'production')
    <script src="{{ asset('js/vue.js') }}"></script>
@else
    <script src="{{ asset('js/vue-dev.js') }}"></script>
@endif