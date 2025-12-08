<!-- ----------------------------------------------------------------------- -->
<!-- Header Component -->
<!-- ----------------------------------------------------------------------- -->
<div class="row justify-content-between p-1">

    <!-- ------------------------------- -->
    <!-- Logo whith link to homepage -->
    <!-- ------------------------------- -->
    <div class="col-md-6 mt-1">
        <a href="/">
            <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
        </a>
    </div>

    <!-- ------------------------------- -->
    <!-- Login/register button to the right -->
    <!-- ------------------------------- -->
    <div class="col-md-4 text-end align-self-center mt-1">
        @if (Route::has('login'))
            @auth

                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/">{{ __('Home') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{ url('/dashboard') }}">{{ __('Dashboard') }}</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"><span class="me-2">{{ Auth::user()->name }}</span></a>
                        <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">{{ __('Profile') }}</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    {{ __('Log Out') }}
                                </button>
                            </form>
                        </li>

                        </ul>
                    </li>
                </ul>



                    @else
                <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">{{ __('Log in') }}</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-primary">{{ __('Register') }}</a>
                @endif
            @endauth
        @endif

    </div>
</div>