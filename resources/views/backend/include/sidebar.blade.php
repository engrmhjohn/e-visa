<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="{{ route('dashboard') }}" class="logo text-white text-center fw-bold">
                {{-- <img src="{{ asset('frontendAssets') }}/img/logo.png" alt="navbar brand" class="navbar-brand bg-white" height="40" /> --}}
                E-Visa Dashboard
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item active">
                    <a href="{{ route('dashboard') }}">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item active">
                    <a href="{{ route('apply.now') }}">
                        <i class="fas fa-external-link-alt"></i>
                        <p>Apply Now</p>
                    </a>
                </li>
                @if(Auth::user()->role == 0)
                <li class="nav-item active">
                    <a href="{{ route('manage_my_application') }}">
                        <i class="fas fa-passport"></i>
                        <p>My Applications</p>
                    </a>
                </li>
                @endif
                @if(Auth::user()->role == 2)
                <li class="nav-item active">
                    <a href="{{ route('manage_visa_application') }}">
                        <i class="fas fa-passport"></i>
                        <p>All Applications</p>
                    </a>
                </li>
                @endif
                <li class="nav-item active">
                    <a href="{{ route('application.track') }}">
                        <i class="fas fa-search"></i>
                        <p>Track Application</p>
                    </a>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Admin Management</h4>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#auth">
                        <i class="fas fa-user-lock"></i>
                        <p>Admin</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="auth">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{ route('admin.manage_admin') }}">
                                    <i class="fas fa-user-friends"></i>
                                    <span class="sub-item">All User</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.super_admin_user') }}">
                                    <i class="fas fa-user-shield"></i>
                                    <span class="sub-item">Admin</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>