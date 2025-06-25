<nav class="navbar navbar-expand-lg navbar-light bg-white px-lg-3 py-lg-2 shadow-sm sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand me-5 fw-bold fs-3 h-font text-primary" href="{{ url('/') }}">PK FUTSAL</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item me-2"><a class="nav-link active" href="{{ url('/') }}">Home</a></li>
                <li class="nav-item me-2"><a class="nav-link" href="{{ url('/courts') }}">Courts</a></li>
                <li class="nav-item me-2"><a class="nav-link" href="{{ url('/facilities') }}">Facilities</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/about') }}">About Us</a></li>
            </ul>
            <div class="d-flex align-items-center">
                @auth
                <!-- User Dropdown -->
                <div class="dropdown">
                    <button class="btn btn-link p-0 border-0 shadow-none" type="button" id="userDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <!-- User SVG Icon -->
                        <img src={{ asset('image/svg/user.svg') }} alt="user" />
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                        <li class="dropdown-header">
                            <div class="fw-bold">{{ Auth::user()->name }}</div>
                            <div class="text-muted small">{{ Auth::user()->email }}</div>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li class="mb-2">
                            <button type="submit" class="dropdown-item ">
                                Booking status
                            </button>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="d-inline w-100">
                                @csrf
                                <button type="submit" class="dropdown-item ">
                                    <img src={{ asset('image/svg/logout.svg') }} alt="logout" />
                                    Logout
                                </button>
                            </form>
                        </li>

                    </ul>
                </div>
                @endauth
                @guest
                <a href="{{ url('/login') }}" class="btn btn-outline-primary shadow-none me-lg-3 me-2">Login</a>
                <a href="{{ url('/register') }}" class="btn btn-outline-primary shadow-none ">Register</a>
                @endguest
                <a href="{{ url('/booking') }}" class="btn btn-primary mx-2">Book</a>
            </div>

        </div>
    </div>
</nav>

@section('scripts')

@endsection