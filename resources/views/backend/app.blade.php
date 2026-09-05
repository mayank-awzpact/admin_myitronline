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

                   <li class="nav-item">
    <a class="nav-link d-flex justify-content-between align-items-center {{ request()->routeIs('services.*') ? 'active' : '' }}"
       data-bs-toggle="collapse"
       href="#servicesMenu"
       role="button"
       aria-expanded="{{ request()->routeIs('services.*') ? 'true' : 'false' }}">
        <span><i class="bi bi-gear"></i> Services</span>
        <i class="bi bi-chevron-down"></i>
    </a>

    <div class="collapse {{ request()->routeIs('services.*') ? 'show' : '' }}" id="servicesMenu">
        <ul class="nav flex-column ms-3">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('services.index') ? 'active' : '' }}"
                   href="{{ route('services.index') }}">
                    <i class="bi bi-gear"></i> Services
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('services.servicemeta') ? 'active' : '' }}"
                   href="{{ route('services.servicemeta') }}">
                    <i class="bi bi-bookmark-plus"></i> Services Meta
                </a>
            </li>
        </ul>
    </div>
</li>


                    <li class="nav-item">
    <a class="nav-link d-flex justify-content-between align-items-center {{ request()->is('order/*') ? 'active' : '' }}"
       data-bs-toggle="collapse"
       href="#paymentMenu"
       role="button"
       aria-expanded="{{ request()->is('order/*') ? 'true' : 'false' }}">
        <span><i class="bi bi-currency-rupee"></i> Payment</span>
        <i class="bi bi-chevron-down"></i>
    </a>

    <div class="collapse {{ request()->is('order/*') ? 'show' : '' }}" id="paymentMenu">
        <ul class="nav flex-column ms-3">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('order.consultancy') ? 'active' : '' }}"
                   href="{{ route('order.consultancy') }}">
                    <i class="bi bi-wallet2"></i> Consultation Payment
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('order.index') ? 'active' : '' }}"
                   href="{{ route('order.index') }}">
                    <i class="bi bi-basket"></i> Orders
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('order.oldorder') ? 'active' : '' }}"
                   href="{{ route('order.oldorder') }}">
                    <i class="bi bi-archive"></i> Old Payment
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('order.form16_payment') ? 'active' : '' }}"
                   href="{{ route('order.form16_payment') }}">
                    <i class="bi bi-file-text"></i> Form16 Payment
                </a>
            </li>
        </ul>
    </div>
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
    <a class="nav-link d-flex justify-content-between align-items-center {{ request()->routeIs('events.*') ? 'active' : '' }}"
       data-bs-toggle="collapse"
       href="#eventsMenu"
       role="button"
       aria-expanded="{{ request()->routeIs('events.*') ? 'true' : 'false' }}">
        <span><i class="bi bi-calendar-event"></i> Office Events</span>
        <i class="bi bi-chevron-down"></i>
    </a>

    <div class="collapse {{ request()->routeIs('events.*') ? 'show' : '' }}" id="eventsMenu">
        <ul class="nav flex-column ms-3">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('events.index') && !request('trashed') ? 'active' : '' }}"
                   href="{{ route('events.index') }}">
                    <i class="bi bi-list-ul"></i> All Events
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('events.create') ? 'active' : '' }}"
                   href="{{ route('events.create') }}">
                    <i class="bi bi-plus-circle"></i> Add Event
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('events.index') && request('trashed') ? 'active' : '' }}"
                   href="{{ route('events.index', ['trashed' => 1]) }}">
                    <i class="bi bi-trash"></i> Trashed Events
                </a>
            </li>
        </ul>
    </div>
</li>

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

                    <li class="nav-item">
    <a class="nav-link d-flex justify-content-between align-items-center {{ request()->routeIs('users.*') ? 'active' : '' }}"
       data-bs-toggle="collapse"
       href="#userMenu"
       role="button"
       aria-expanded="{{ request()->routeIs('users.*') ? 'true' : 'false' }}">
        <span><i class="bi bi-people"></i> User Management</span>
        <i class="bi bi-chevron-down"></i>
    </a>

    <div class="collapse {{ request()->routeIs('users.*') ? 'show' : '' }}" id="userMenu">
        <ul class="nav flex-column ms-3">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}"
                   href="{{ route('users.index') }}">
                    <i class="bi bi-person-plus"></i> Add User
                </a>
            </li>
        </ul>
    </div>
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
                      <div class="nav-item user-dropdown position-relative">

    <a class="nav-link d-flex align-items-center justify-content-between"
       data-bs-toggle="collapse"
       href="#userProfileMenu"
       role="button"
       id="userToggle"
       aria-expanded="false">

        <span>
            <i class="bi bi-person-circle"></i>
            {{ Auth::user()->name }}
        </span>

        <i class="bi bi-chevron-down small"></i>
    </a>

    <div class="collapse position-absolute end-0 mt-2 shadow bg-white rounded p-3"
         id="userProfileMenu"
         style="min-width:220px; z-index:999;">

        <div class="mb-2">
            <strong>{{ Auth::user()->name }}</strong><br>
            <small class="text-muted">{{ Auth::user()->email }}</small>
        </div>

        <hr>

        <a class="btn btn-sm btn-outline-primary w-100 mb-2" href="#">
            <i class="bi bi-person"></i> Edit Profile
        </a>

        <form method="POST" action="{{ route('logout') }}" id="logoutForm">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>

    </div>
</div>


                    @endauth
                    @guest
                        <a class="nav-link" href="{{ route('administrator.login') }}">Login</a>
                        @if (Route::has('register'))
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        @endif
                    @endguest
                </div>
            </nav>

            <section class="content">
                @yield('content')
            </section>
        </div>
    </div>

   <script src="{{ asset('cdn/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('cdn/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('cdn/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('cdn/js/select2.min.js') }}"></script>
    <script src="{{ asset('cdn/js/flatpickr.js') }}"></script>


    <script src="{{ asset('js/script.js') }}"></script>
    <script>
document.addEventListener("DOMContentLoaded", function () {

    const userMenu = document.getElementById('userProfileMenu');
    const userToggle = document.getElementById('userToggle');
    const logoutForm = document.getElementById('logoutForm');

    // Toggle manually for safety
    userToggle.addEventListener('click', function () {
        const bsCollapse = bootstrap.Collapse.getOrCreateInstance(userMenu);
        bsCollapse.toggle();
    });

    // Close on outside click
    document.addEventListener('click', function (event) {
        if (!userToggle.contains(event.target) && !userMenu.contains(event.target)) {
            const bsCollapse = bootstrap.Collapse.getOrCreateInstance(userMenu);
            bsCollapse.hide();
        }
    });

    // Hide before logout
    logoutForm.addEventListener('submit', function () {
        const bsCollapse = bootstrap.Collapse.getOrCreateInstance(userMenu);
        bsCollapse.hide();
    });

});
</script>

</body>

</html>
