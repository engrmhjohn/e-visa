    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top shadow-sm">
        <div class="container">

            <!-- Logo -->
            <a class="navbar-brand fw-bold" href="{{ route('/') }}">
                {{-- <img src="https://via.placeholder.com/40" alt="Logo" class="me-2"> --}}
                <h1 class="mb-0 fw-bold">E-Visa</h1>
            </a>

            <i class="mobile-nav-toggle bi bi-list"></i>

            <!-- Navbar Items -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item ms-lg-3">
                        <a href="{{ route('apply.now') }}" class="btn btn-outline">Apply Now</a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a href="{{ route('application.track') }}" class="btn btn-outline">Track</a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a href="#" class="btn btn-outline">Verify</a>
                    </li>
                    @if(Auth::check())
                    <li class="nav-item ms-lg-3">
                        <a href="{{ route('dashboard') }}" class="btn btn-primary">Dashboard</a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout').submit()"><i class="bi bi-box-arrow-right"></i> Logout
                            <form action="{{ route('logout') }}" method="post" id="logout" style="display: none">
                                @csrf
                            </form>
                        </a>
                    </li>
                    @else
                    <li class="nav-item ms-lg-3">
                        <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- ======= Mobile Menu ======= -->
    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container-fluid position-relative d-flex align-items-center justify-content-between">

            <a href="{{ route('/') }}" class="logo d-flex align-items-center">
            </a>

            <nav id="navmenu" class="navmenu">

                <div class="profile-img">
                    <img src="{{ asset('frontendAssets') }}/img/profile-square-1.webp" alt="" class="img-fluid rounded-circle">
                </div>

                <a href="{{ route('/') }}" class="logo d-flex align-items-center justify-content-center active">
                    @if(Auth::check())
                    <h1 class="sitename">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h1>
                    @else
                    <h1 class="sitename">Undefined User</h1>
                    @endif
                </a>

                <ul>
                    <li><a href="{{ route('apply.now') }}">Apply Now</a></li>
                    <li><a href="{{ route('application.track') }}">Track</a></li>
                    <li><a href="#">Verify</a></li>
                    @if(Auth::check())
                    <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li>
                        <a class="btn btn-sm btn-outline-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout').submit()"><i class="bi bi-box-arrow-right"></i> Logout
                            <form class="d-inline" action="{{ route('logout') }}" method="post" id="logout">
                                @csrf
                            </form>
                        </a>
                    </li>
                    @else
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
                    @endif
                </ul>
            </nav>

        </div>
    </header>
