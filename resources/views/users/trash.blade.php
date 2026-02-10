@extends('backend.app')
@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-lg" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);">
                <div class="card-body text-white py-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="bg-white text-black bg-opacity-20 rounded-circle p-3 me-3">
                                <i class="bi bi-trash fs-2"></i>
                            </div>
                            <div>
                                <h2 class="fw-bold mb-1">Deleted Users</h2>
                                <p class="mb-0 opacity-75">Manage and restore deleted user accounts</p>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('users.index') }}" class="btn btn-outline-light btn-lg">
                                <i class="bi bi-arrow-left me-2"></i>Back to Users
                            </a>
                            @if($users->count() > 0)
                                <button class="btn btn-light btn-lg" onclick="showBulkActions()">
                                    <i class="bi bi-gear me-2"></i>Bulk Actions
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-dark">
                            <i class="bi bi-funnel me-2 text-primary"></i>Search Deleted Users
                        </h5>
                        <button class="btn btn-sm btn-outline-primary d-md-none" type="button"
                                data-bs-toggle="collapse" data-bs-target="#searchCollapse">
                            <i class="bi bi-sliders me-1"></i> Toggle Search
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="collapse d-md-block" id="searchCollapse">
                        <form method="GET" action="{{ route('users.trash') }}">
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
                                        @if(request('search'))
                                            <a href="{{ route('users.trash') }}" class="btn btn-outline-secondary shadow-sm flex-fill">
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
                            <i class="bi bi-trash me-1"></i>
                            @if(request('search'))
                                Search results for "<strong>{{ request('search') }}</strong>" -
                            @endif
                            Showing <strong>{{ $users->count() }}</strong> of <strong>{{ $users->total() }}</strong> deleted users
                        </span>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-outline-primary" onclick="window.location.reload()">
                                <i class="bi bi-arrow-clockwise me-1"></i>Refresh
                            </button>
                            @if($users->count() > 0)
                                <button class="btn btn-sm btn-outline-success" onclick="showRestoreAllModal()">
                                    <i class="bi bi-arrow-counterclockwise me-1"></i>Restore All
                                </button>
                            @endif
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
                                    <th class="py-3">
                                        @if($users->count() > 0)
                                            <input type="checkbox" id="selectAll" class="form-check-input">
                                        @else
                                            #
                                        @endif
                                    </th>
                                    <th class="py-3"><i class="bi bi-person me-1"></i>Name</th>
                                    <th class="py-3"><i class="bi bi-envelope me-1"></i>Email</th>
                                    <th class="py-3"><i class="bi bi-calendar-x me-1"></i>Deleted At</th>
                                    <th class="py-3"><i class="bi bi-gear me-1"></i>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $index => $user)
                                    <tr class="text-center user-row" data-user-id="{{ $user->id }}">
                                        <td>
                                            <input type="checkbox" class="form-check-input user-checkbox"
                                                   value="{{ $user->id }}">
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center justify-content-center">
                                                <div class="bg-danger bg-opacity-10 rounded-circle p-2 me-2">
                                                    <i class="bi bi-person-x text-danger"></i>
                                                </div>
                                                <span class="user-name fw-semibold text-muted">{{ $user->name }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ $user->email }}</span>
                                        </td>
                                        <td class="text-muted">
                                            <div class="d-flex flex-column align-items-center">
                                                <span class="fw-medium">{{ \Carbon\Carbon::parse($user->updated_at)->format('d M Y') }}</span>
                                                <small class="text-muted">{{ \Carbon\Carbon::parse($user->updated_at)->format('h:i A') }}</small>
                                                <small class="badge bg-danger bg-opacity-10 text-danger mt-1">
                                                    {{ \Carbon\Carbon::parse($user->updated_at)->diffForHumans() }}
                                                </small>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1 justify-content-center">
                                                <button class="btn btn-success btn-sm shadow-sm restore-btn"
                                                        data-user-id="{{ $user->id }}"
                                                        data-user-name="{{ $user->name }}"
                                                        title="Restore User" data-bs-toggle="tooltip">
                                                    <i class="bi bi-arrow-counterclockwise"></i>
                                                </button>
                                                <button class="btn btn-info btn-sm shadow-sm"
                                                        onclick="showUserDetails('{{ $user->id }}', '{{ $user->name }}', '{{ $user->email }}', '{{ \Carbon\Carbon::parse($user->updated_at)->format('M d, Y h:i A') }}')"
                                                        title="View Details" data-bs-toggle="tooltip">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <div class="text-muted">
                                                @if(request('search'))
                                                    <i class="bi bi-search display-1 d-block mb-3"></i>
                                                    <h5>No deleted users found</h5>
                                                    <p>No deleted users match your search criteria.</p>
                                                    <a href="{{ route('users.trash') }}" class="btn btn-outline-primary">
                                                        <i class="bi bi-arrow-left me-1"></i>View All Deleted Users
                                                    </a>
                                                @else
                                                    <i class="bi bi-trash display-1 d-block mb-3"></i>
                                                    <h5>No deleted users</h5>
                                                    <p>There are no deleted users in the system.</p>
                                                    <a href="{{ route('users.index') }}" class="btn btn-primary">
                                                        <i class="bi bi-arrow-left me-1"></i>Back to Users
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

    @if($users->hasPages())
        <div class="row mt-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div class="text-muted mb-2 mb-md-0">
                        <span>Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} results</span>
                    </div>
                    <nav aria-label="Deleted users pagination">
                        <div class="pagination-wrapper">
                            {{ $users->links() }}
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    @endif
</div>

<div class="modal fade" id="userDetailsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="bi bi-person-x me-2"></i>Deleted User Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-12">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-danger bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="bi bi-person-x text-danger fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-1" id="modalUserName">User Name</h6>
                                <small class="text-muted" id="modalUserEmail">user@example.com</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <strong>User ID:</strong>
                        <p class="text-muted" id="modalUserId">-</p>
                    </div>
                    <div class="col-6">
                        <strong>Deleted At:</strong>
                        <p class="text-muted" id="modalDeletedAt">-</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="modalRestoreBtn">
                    <i class="bi bi-arrow-counterclockwise me-1"></i>Restore User
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="bulkRestoreModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="bi bi-arrow-counterclockwise me-2"></i>Bulk Restore Users
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to restore the selected users?</p>
                <div id="selectedUsersCount" class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>No users selected
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="confirmBulkRestore">
                    <i class="bi bi-arrow-counterclockwise me-1"></i>Restore Selected
                </button>
            </div>
        </div>
    </div>
</div>

<div id="loadingOverlay" class="position-fixed top-0 start-0 w-100 h-100 d-none"
     style="background: rgba(0,0,0,0.5); z-index: 9999;">
    <div class="d-flex justify-content-center align-items-center h-100">
        <div class="card border-0 shadow-lg">
            <div class="card-body text-center py-4">
                <div class="spinner-border text-success mb-3" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <h5 class="text-muted">Restoring User...</h5>
            </div>
        </div>
    </div>
</div>

<style>
    .user-row:hover {
        background-color: rgba(220, 53, 69, 0.05);
        transform: translateY(-1px);
        transition: all 0.2s ease;
    }

    .card {
        transition: all 0.3s ease;
    }

    .btn {
        transition: all 0.2s ease;
    }

    .btn:hover {
        transform: translateY(-1px);
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .user-name {
        color: #6c757d;
    }

    .pagination-wrapper .pagination {
        margin-bottom: 0;
    }

    .pagination-wrapper .page-link {
        border: none;
        margin: 0 2px;
        border-radius: 8px;
        color: #667eea;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .pagination-wrapper .page-item.active .page-link {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }

    .pagination-wrapper .page-link:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
    }

    .table-hover tbody tr:hover {
        background-color: rgba(220, 53, 69, 0.05);
    }

    .btn-success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border: none;
    }

    .btn-success:hover {
        background: linear-gradient(135deg, #20c997 0%, #28a745 100%);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
    }

    .btn-info {
        background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
        border: none;
    }

    .btn-info:hover {
        background: linear-gradient(135deg, #138496 0%, #17a2b8 100%);
    }

    .btn-outline-light:hover {
        background: rgba(255, 255, 255, 0.2);
        border-color: rgba(255, 255, 255, 0.5);
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    }

    .btn-light {
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: #dc3545;
        font-weight: 600;
    }

    .btn-light:hover {
        background: rgba(255, 255, 255, 1);
        color: #c82333;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255, 255, 255, 0.3);
    }

    .form-check-input:checked {
        background-color: #28a745;
        border-color: #28a745;
    }

    .badge {
        font-size: 0.7em;
    }
</style>


<script>
document.addEventListener("DOMContentLoaded", function() {

    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    const selectAllCheckbox = document.getElementById('selectAll');
    const userCheckboxes = document.querySelectorAll('.user-checkbox');

    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            userCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateBulkActionButtons();
        });
    }

    userCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const checkedCount = document.querySelectorAll('.user-checkbox:checked').length;
            if (selectAllCheckbox) {
                selectAllCheckbox.checked = checkedCount === userCheckboxes.length;
                selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < userCheckboxes.length;
            }
            updateBulkActionButtons();
        });
    });

    function updateBulkActionButtons() {
        const checkedCount = document.querySelectorAll('.user-checkbox:checked').length;
        document.getElementById('selectedUsersCount').innerHTML =
            `<i class="bi bi-info-circle me-2"></i>${checkedCount} user(s) selected`;
    }

    document.querySelectorAll('.restore-btn').forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.dataset.userId;
            const userName = this.dataset.userName;

            if (confirm(`Are you sure you want to restore "${userName}"?\n\nThis will make the user account active again.`)) {
                restoreUser(userId);
            }
        });
    });

    function restoreUser(userId) {
        document.getElementById('loadingOverlay').classList.remove('d-none');

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/users/restore/${btoa(userId)}`;

        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';

        form.appendChild(csrfToken);
        document.body.appendChild(form);
        form.submit();
    }

    window.showUserDetails = function(userId, userName, userEmail, deletedAt) {
        document.getElementById('modalUserId').textContent = userId;
        document.getElementById('modalUserName').textContent = userName;
        document.getElementById('modalUserEmail').textContent = userEmail;
        document.getElementById('modalDeletedAt').textContent = deletedAt;

        document.getElementById('modalRestoreBtn').onclick = function() {
            const modal = bootstrap.Modal.getInstance(document.getElementById('userDetailsModal'));
            modal.hide();
            restoreUser(userId);
        };

        new bootstrap.Modal(document.getElementById('userDetailsModal')).show();
    };

    window.showBulkActions = function() {
        const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
        if (checkedBoxes.length === 0) {
            alert('Please select users to perform bulk actions.');
            return;
        }
        new bootstrap.Modal(document.getElementById('bulkRestoreModal')).show();
    };

    window.showRestoreAllModal = function() {

        userCheckboxes.forEach(checkbox => {
            checkbox.checked = true;
        });
        if (selectAllCheckbox) {
            selectAllCheckbox.checked = true;
        }
        updateBulkActionButtons();
        new bootstrap.Modal(document.getElementById('bulkRestoreModal')).show();
    };

    document.getElementById('confirmBulkRestore').addEventListener('click', function() {
        const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
        if (checkedBoxes.length === 0) {
            alert('No users selected.');
            return;
        }

        const modal = bootstrap.Modal.getInstance(document.getElementById('bulkRestoreModal'));
        modal.hide();


        const firstUserId = checkedBoxes[0].value;
        restoreUser(firstUserId);
    });

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
