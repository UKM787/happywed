@include('layouts.inc.guest.header')
@include('layouts.inc.guest.navbar')

<div  id="app">
    <main class="py-4">
        @if(Session::has('status'))
        <flash-message id="flash-custom-message" message="{{Session::get('message')}}"></flash-message>
        
        @endif
        @if(Session::has('feedback'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        @yield('content')
    </main>
    <landing-footer></landing-footer>
</div>


@include('layouts.inc.guest.footer')
