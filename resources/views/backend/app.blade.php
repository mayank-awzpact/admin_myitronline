<!DOCTYPE html>
<html lang="en">
<head>
    @include('includes.head')
</head>

<body>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="admin-wrapper">
        <nav class="sidebar" id="sidebar">
            <div class="sidebar-header">
                {{-- <h5>MyitrOnline Admin</h5> --}}
                <img src="{{ asset('img/logo/logo_4.png') }}" alt="Logo" style="height:70px; width:200px;">
            </div>

            <div class="sidebar-nav">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}"
                            class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="bi bi-house-door"></i>
                            Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('bulkmail.index') }}"
                            class="nav-link {{ request()->routeIs('bulkmail.*') ? 'active' : '' }}">
                            <i class="bi bi-envelope-at"></i>
                            Bulk Mails
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('utm.index') }}"
                            class="nav-link {{ request()->routeIs('utm.*') ? 'active' : '' }}">
                            <i class="bi bi-graph-up"></i>
                            UTM Data
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('services.*') ? 'active' : '' }}"
                            href="#" id="servicesDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-gear"></i>
                            Services
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('services.index') }}"><i class="bi bi-gear"></i>
                                    Services</a></li>
                            <li><a class="dropdown-item" href="{{ route('services.servicemeta') }}"><i
                                        class="bi bi-bookmark-plus"></i> Services Meta</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->is('order/*') ? 'active' : '' }}"
                            href="#" id="paymentDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-currency-rupee"></i>
                            Payment
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('order.consultancy') }}"><i
                                        class="bi bi-wallet2"></i> Consultation Payment</a></li>
                            <li><a class="dropdown-item" href="{{ route('order.index') }}"><i class="bi bi-basket"></i>
                                    Orders</a></li>
                            <li><a class="dropdown-item" href="{{ route('order.oldorder') }}"><i
                                        class="bi bi-archive"></i> Old Payment</a></li>
                            <li><a class="dropdown-item" href="{{ route('order.form16_payment') }}"><i
                                        class="bi bi-file-text"></i> Form16 Payment</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('spin.index') }}"
                            class="nav-link {{ request()->routeIs('spin.*') ? 'active' : '' }}">
                            <i class="bi bi-trophy"></i>
                         Spin & Win
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('rent.index') }}"
                            class="nav-link {{ request()->routeIs('rent.index') ? 'active' : '' }}">
                            <i class="bi bi-receipt"></i>
                            Rent Receipts
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('eca_request.index') }}"
                            class="nav-link {{ request()->routeIs('eca_request.index') ? 'active' : '' }}">
                            <i class="bi bi-telephone"></i>
                            ECA Request
                        </a>
                    </li>

                    {{-- <li class="nav-item">
                        <a href="{{ route('guides.index') }}"
                            class="nav-link {{ request()->routeIs('guides.index') ? 'active' : '' }}">
                            <i class="bi bi-journal-richtext"></i>
                            Guides
                        </a>
                    </li> --}}

                    <li class="nav-item">
                        <a href="{{ route('form16.index') }}"
                            class="nav-link {{ request()->routeIs('form16.index') ? 'active' : '' }}">
                            <i class="bi bi-file-pdf"></i>
                            Form16 Data
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('form16.direct') }}"
                            class="nav-link {{ request()->routeIs('form16.direct') ? 'active' : '' }}">
                            <i class="bi bi-upload"></i>
                            Direct Upload Form16
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('users.index') ? 'active' : '' }}"
                            href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-people"></i>
                            User Management
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('users.index') }}"><i
                                        class="bi bi-person-plus"></i> Add User</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="main-content">
            <nav class="top-navbar">
                <div class="navbar-left">
                    <button class="mobile-toggle" type="button" onclick="toggleSidebar()">
                        <i class="bi bi-list"></i>
                    </button>

                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="{{ asset('img/logo/logo.png') }}" alt="Logo">
                    </a>
                </div>

                <div class="navbar-right">
                    @auth
                        <div class="nav-item dropdown user-dropdown">
                            <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i>
                                <span>{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li class="dropdown-item-text">
                                    <strong>{{ Auth::user()->name }}</strong><br>
                                    <small class="text-muted">{{ Auth::user()->email }}</small>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-person"></i> Edit Profile</a>
                                </li>
                                {{-- <li><a class="dropdown-item" href="#"><i class="bi bi-gear"></i> Settings</a></li> --}}
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bi bi-box-arrow-right"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endauth
                    @guest
                        <a class="nav-link" href="{{ route('administrator.login') }}">Login</a>
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    @endguest
                </div>
            </nav>

            <section class="content">
                @yield('content')
            </section>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
