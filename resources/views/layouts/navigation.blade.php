<!-- filepath: /var/Projects/Rentio/resources/views/layouts/navigation.blade.php -->
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('dashboard') }}">
            <x-application-logo class="d-inline-block align-text-top" />
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#primaryNavbar" aria-controls="primaryNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="primaryNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        {{ __('Dashboard') }}
                    </a>
                </li>
                <!-- ...legg evt. til flere nav-lenker her... -->
            </ul>

            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="me-2">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">{{ __('Profile') }}</a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
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
        </div>
    </div>
</nav>