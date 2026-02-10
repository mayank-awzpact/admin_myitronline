@extends('backend.app')
@section('content')
    <div class="container-fluid py-4">

        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-lg" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <div class="card-body text-white py-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="bg-white text-black bg-opacity-20 rounded-circle p-3 me-3">
                                    <i class="bi bi-people fs-2"></i>
                                </div>
                                <div>
                                    <h2 class="fw-bold mb-1">User Management</h2>
                                    <p class="mb-0 opacity-75">Manage and organize system users efficiently</p>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('users.form') }}" class="btn btn-light btn-lg shadow-sm">
                                    <i class="bi bi-plus-circle me-2"></i>Add User
                                </a>
                                {{-- <a href="{{ route('users.trash') }}" class="btn btn-outline-light btn-lg">
                                    <i class="bi bi-trash me-2"></i>View Trash
                                </a> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="row mb-4">
                <div class="col-12">
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        <i class="bi bi-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="row mb-4">
                <div class="col-12">
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        @endif

        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-dark">
                                <i class="bi bi-funnel me-2 text-primary"></i>Search & Filter
                            </h5>
                            <button class="btn btn-sm btn-outline-primary d-md-none" type="button"
                                data-bs-toggle="collapse" data-bs-target="#searchCollapse">
                                <i class="bi bi-sliders me-1"></i> Toggle Search
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="collapse d-md-block" id="searchCollapse">
                            <form method="GET" action="{{ route('users.index') }}">
                                <div class="row g-3">
                                    <div class="col-lg-8 col-md-8">
                                        <label for="searchInput" class="form-label fw-semibold text-muted">
                                            <i class="bi bi-search me-1"></i>Search Users
                                        </label>
                                        <div class="input-group shadow-sm">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-search text-muted"></i>
                                            </span>
                                            <input type="text" name="search" class="form-control border-start-0"
                                                id="searchInput" placeholder="Search by name or email..."
                                                value="{{ request('search') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <label class="form-label fw-semibold text-muted">Actions</label>
                                        <div class="d-flex gap-2">
                                            <button type="submit" class="btn btn-primary shadow-sm flex-fill">
                                                <i class="bi bi-search me-1"></i>Search
                                            </button>
                                            @if (request('search'))
                                                <a href="{{ route('users.index') }}"
                                                    class="btn btn-outline-secondary shadow-sm flex-fill">
                                                    <i class="bi bi-x-circle me-1"></i>Clear
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <div class="card border-0 bg-light">
                    <div class="card-body py-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted fw-medium">
                                <i class="bi bi-list-ul me-1"></i>
                                @if (request('search'))
                                    Search results for "<strong>{{ request('search') }}</strong>" -
                                @endif
                                Showing <strong>{{ $users->count() }}</strong> of <strong>{{ $users->total() }}</strong>
                                users
                            </span>
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-outline-primary" onclick="window.location.reload()">
                                    <i class="bi bi-arrow-clockwise me-1"></i>Refresh
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-dark">
                                    <tr class="text-center">
                                        <th class="py-3">#</th>
                                        <th class="py-3"><i class="bi bi-person me-1"></i>Name</th>
                                        <th class="py-3"><i class="bi bi-envelope me-1"></i>Email</th>
                                        <th class="py-3"><i class="bi bi-calendar me-1"></i>Created At</th>
                                        <th class="py-3"><i class="bi bi-gear me-1"></i>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $index => $user)
                                        <tr class="text-center user-row">
                                            <td class="fw-bold text-primary">{{ $users->firstItem() + $index }}</td>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-2">
                                                        <i class="bi bi-person text-primary"></i>
                                                    </div>
                                                    <span class="user-name fw-semibold">{{ $user->name }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="mailto:{{ $user->email }}"
                                                    class="text-decoration-none text-muted">
                                                    {{ $user->email }}
                                                </a>
                                            </td>
                                            <td class="text-muted">
                                                <div class="d-flex flex-column align-items-center">
                                                    <span
                                                        class="fw-medium">{{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}</span>
                                                    <small
                                                        class="text-muted">{{ \Carbon\Carbon::parse($user->created_at)->format('h:i A') }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1 justify-content-center">
                                                    <a href="{{ route('users.edit', Crypt::encryptString($user->id)) }}"
                                                        class="btn btn-warning btn-sm shadow-sm" title="Edit User"
                                                        data-bs-toggle="tooltip">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                    <form
                                                        action="{{ route('users.destroy', Crypt::encryptString($user->id)) }}"
                                                        method="POST" class="d-inline delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm shadow-sm"
                                                            title="Delete User" data-bs-toggle="tooltip">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5">
                                                <div class="text-muted">
                                                    <i class="bi bi-people display-1 d-block mb-3"></i>
                                                    <h5>No users found</h5>
                                                    @if (request('search'))
                                                        <p>No users match your search criteria. Try adjusting your search
                                                            terms.</p>
                                                        <a href="{{ route('users.index') }}"
                                                            class="btn btn-outline-primary">
                                                            <i class="bi bi-arrow-left me-1"></i>View All Users
                                                        </a>
                                                    @else
                                                        <p>Get started by adding your first user.</p>
                                                        <a href="{{ route('users.form') }}" class="btn btn-primary">
                                                            <i class="bi bi-plus-circle me-1"></i>Add First User
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($users->hasPages())
            <div class="row mt-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div class="text-muted mb-2 mb-md-0">
                            <span>Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }}
                                results</span>
                        </div>
                        <nav aria-label="Users pagination">
                            <div class="pagination-wrapper">
                                {{ $users->links() }}
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div id="loadingOverlay" class="position-fixed top-0 start-0 w-100 h-100 d-none"
        style="background: rgba(0,0,0,0.5); z-index: 9999;">
        <div class="d-flex justify-content-center align-items-center h-100">
            <div class="card border-0 shadow-lg">
                <div class="card-body text-center py-4">
                    <div class="spinner-border text-primary mb-3" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <h5 class="text-muted">Processing...</h5>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function() {

            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });


            document.querySelectorAll('.delete-form').forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    if (confirm(
                            '⚠️ Are you sure you want to delete this user?\n\nThis action cannot be undone and will permanently remove the user from the system.'
                            )) {

                        document.getElementById('loadingOverlay').classList.remove('d-none');

                        setTimeout(() => {
                            form.submit();
                        }, 500);
                    }
                });
            });

            setTimeout(function() {
                document.querySelectorAll('.alert').forEach(function(alert) {
                    var bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);


            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('focus', function() {
                    this.parentElement.classList.add('shadow');
                });

                searchInput.addEventListener('blur', function() {
                    this.parentElement.classList.remove('shadow');
                });
            }

            document.querySelector('form').addEventListener('submit', function() {
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i>Searching...';
                    submitBtn.disabled = true;
                }
            });
        });
    </script>
@endsection
