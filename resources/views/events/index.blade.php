@extends('backend.app')
@section('content')
    <div class="container-fluid py-4">

        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-lg" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <div class="card-body text-white py-4">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-white text-black bg-opacity-20 rounded-circle p-3 me-3">
                                    <i class="bi bi-calendar-event fs-2"></i>
                                </div>
                                <div>
                                    <h2 class="fw-bold mb-1">
                                        {{ $trashed ? 'Trashed Events' : 'Office Events' }}
                                    </h2>
                                    <p class="mb-0 opacity-75">
                                        Manage office events, holidays &amp; celebrations shown on the website
                                    </p>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                @if ($trashed)
                                    <a href="{{ route('events.index') }}" class="btn btn-light btn-lg shadow-sm">
                                        <i class="bi bi-arrow-left me-2"></i>Back to Events
                                    </a>
                                @else
                                    <a href="{{ route('events.create') }}" class="btn btn-light btn-lg shadow-sm">
                                        <i class="bi bi-plus-circle me-2"></i>Add Event
                                    </a>
                                    <a href="{{ route('events.index', ['trashed' => 1]) }}"
                                        class="btn btn-outline-light btn-lg">
                                        <i class="bi bi-trash me-2"></i>Trash
                                        @if ($trashCount)
                                            <span class="badge bg-light text-dark ms-1">{{ $trashCount }}</span>
                                        @endif
                                    </a>
                                @endif
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
                                <i class="bi bi-funnel me-2 text-primary"></i>Search &amp; Filter
                            </h5>
                            <button class="btn btn-sm btn-outline-primary d-md-none" type="button"
                                data-bs-toggle="collapse" data-bs-target="#searchCollapse">
                                <i class="bi bi-sliders me-1"></i> Toggle Search
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="collapse d-md-block" id="searchCollapse">
                            <form method="GET" action="{{ route('events.index') }}" id="filterForm">
                                @if ($trashed)
                                    <input type="hidden" name="trashed" value="1">
                                @endif
                                <div class="row g-3">
                                    <div class="col-lg-4 col-md-6">
                                        <label for="searchInput" class="form-label fw-semibold text-muted">
                                            <i class="bi bi-search me-1"></i>Search
                                        </label>
                                        <div class="input-group shadow-sm">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-search text-muted"></i>
                                            </span>
                                            <input type="text" name="search" class="form-control border-start-0"
                                                id="searchInput" placeholder="Title, venue or employee..."
                                                value="{{ request('search') }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-6">
                                        <label class="form-label fw-semibold text-muted">Event Type</label>
                                        <select name="eventType" class="form-select shadow-sm">
                                            <option value="">All Types</option>
                                            @foreach ($eventTypes as $key => $label)
                                                <option value="{{ $key }}"
                                                    {{ request('eventType') === $key ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-2 col-md-4">
                                        <label class="form-label fw-semibold text-muted">Status</label>
                                        <select name="status" class="form-select shadow-sm">
                                            <option value="">All Status</option>
                                            <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active
                                            </option>
                                            <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-lg-2 col-md-4">
                                        <label class="form-label fw-semibold text-muted">From Date</label>
                                        <input type="date" name="from_date" class="form-control shadow-sm"
                                            value="{{ request('from_date') }}">
                                    </div>

                                    <div class="col-lg-2 col-md-4">
                                        <label class="form-label fw-semibold text-muted">To Date</label>
                                        <input type="date" name="to_date" class="form-control shadow-sm"
                                            value="{{ request('to_date') }}">
                                    </div>

                                    <div class="col-12">
                                        <div class="d-flex gap-2">
                                            <button type="submit" class="btn btn-primary shadow-sm">
                                                <i class="bi bi-search me-1"></i>Search
                                            </button>
                                            @if (request()->hasAny(['search', 'eventType', 'status', 'from_date', 'to_date']))
                                                <a href="{{ route('events.index', $trashed ? ['trashed' => 1] : []) }}"
                                                    class="btn btn-outline-secondary shadow-sm">
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
                                Showing <strong>{{ $events->count() }}</strong> of
                                <strong>{{ $events->total() }}</strong> events
                            </span>
                            <button class="btn btn-sm btn-outline-primary" onclick="window.location.reload()">
                                <i class="bi bi-arrow-clockwise me-1"></i>Refresh
                            </button>
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
                                        <th class="py-3"><i class="bi bi-image me-1"></i>Banner</th>
                                        <th class="py-3 text-start"><i class="bi bi-card-heading me-1"></i>Event</th>
                                        <th class="py-3"><i class="bi bi-calendar3 me-1"></i>Date</th>
                                        <th class="py-3"><i class="bi bi-geo-alt me-1"></i>Venue / Employee</th>
                                        <th class="py-3"><i class="bi bi-images me-1"></i>Media</th>
                                        <th class="py-3"><i class="bi bi-sort-numeric-down me-1"></i>Priority</th>
                                        <th class="py-3"><i class="bi bi-toggle-on me-1"></i>Status</th>
                                        <th class="py-3"><i class="bi bi-gear me-1"></i>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($events as $index => $event)
                                        @php $encId = Crypt::encryptString($event->uniqueId); @endphp
                                        <tr class="text-center">
                                            <td class="fw-bold text-primary">{{ $events->firstItem() + $index }}</td>

                                            <td>
                                                @if ($event->eventImage)
                                                    <img src="{{ asset($event->eventImage) }}" alt="{{ $event->eventTitle }}"
                                                        class="rounded shadow-sm"
                                                        style="width:70px;height:50px;object-fit:cover;">
                                                @else
                                                    <div class="bg-light rounded d-flex align-items-center justify-content-center mx-auto"
                                                        style="width:70px;height:50px;">
                                                        <i class="bi bi-image text-muted"></i>
                                                    </div>
                                                @endif
                                            </td>

                                            <td class="text-start">
                                                <span class="fw-semibold d-block">{{ $event->eventTitle }}</span>
                                                <small class="text-muted d-block">{{ $event->eventSlug }}</small>
                                                <span class="badge bg-primary bg-opacity-75 mt-1">
                                                    {{ $eventTypes[$event->eventType] ?? ucfirst($event->eventType) }}
                                                </span>
                                                @if ($event->isHoliday)
                                                    <span class="badge bg-danger mt-1">Holiday</span>
                                                @endif
                                                @if ($event->isRecurring)
                                                    <span class="badge bg-info text-dark mt-1">Recurring</span>
                                                @endif
                                            </td>

                                            <td class="text-muted">
                                                <div class="d-flex flex-column align-items-center">
                                                    <span class="fw-medium">
                                                        {{ \Carbon\Carbon::parse($event->eventDate)->format('d M Y') }}
                                                    </span>
                                                    @if ($event->eventEndDate)
                                                        <small class="text-muted">
                                                            to
                                                            {{ \Carbon\Carbon::parse($event->eventEndDate)->format('d M Y') }}
                                                        </small>
                                                    @endif
                                                    @if ($event->eventTime)
                                                        <small class="text-muted">
                                                            <i class="bi bi-clock me-1"></i>{{ $event->eventTime }}
                                                        </small>
                                                    @endif
                                                </div>
                                            </td>

                                            <td class="text-muted">
                                                @if ($event->eventVenue)
                                                    <span class="d-block">{{ $event->eventVenue }}</span>
                                                @endif
                                                @if ($event->employeeName)
                                                    <small class="d-block">
                                                        <i class="bi bi-person me-1"></i>{{ $event->employeeName }}
                                                    </small>
                                                @endif
                                                @if (!$event->eventVenue && !$event->employeeName)
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>

                                            <td>
                                                <span class="badge bg-secondary">
                                                    <i class="bi bi-images me-1"></i>{{ $event->mediaCount }}
                                                </span>
                                                @if ($event->driveUrl)
                                                    <a href="{{ $event->driveUrl }}" target="_blank" rel="noopener"
                                                        class="badge bg-success text-decoration-none"
                                                        title="Open album link">
                                                        <i class="bi bi-link-45deg"></i>
                                                    </a>
                                                @endif
                                            </td>

                                            <td class="text-muted">{{ $event->priority ?? '-' }}</td>

                                            <td>
                                                @if ($trashed)
                                                    <span class="badge bg-dark">Trashed</span>
                                                @else
                                                    <form action="{{ route('events.toggleStatus', $encId) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        <div class="form-check form-switch d-flex justify-content-center mb-0">
                                                            <input class="form-check-input status-toggle" type="checkbox"
                                                                role="switch" style="cursor:pointer;"
                                                                {{ (int) $event->status === 1 ? 'checked' : '' }}
                                                                title="{{ (int) $event->status === 1 ? 'Click to deactivate' : 'Click to activate' }}">
                                                        </div>
                                                    </form>
                                                    <small
                                                        class="d-block mt-1 {{ (int) $event->status === 1 ? 'text-success' : 'text-danger' }}">
                                                        {{ (int) $event->status === 1 ? 'Active' : 'Inactive' }}
                                                    </small>
                                                @endif
                                            </td>

                                            <td>
                                                <div class="d-flex gap-1 justify-content-center">
                                                    @if ($trashed)
                                                        <form action="{{ route('events.restore', $encId) }}" method="POST"
                                                            class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success btn-sm shadow-sm"
                                                                title="Restore Event" data-bs-toggle="tooltip">
                                                                <i class="bi bi-arrow-counterclockwise"></i>
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('events.forceDelete', $encId) }}"
                                                            method="POST" class="d-inline force-delete-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm shadow-sm"
                                                                title="Delete Permanently" data-bs-toggle="tooltip">
                                                                <i class="bi bi-x-octagon"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <a href="{{ route('events.edit', $encId) }}"
                                                            class="btn btn-warning btn-sm shadow-sm" title="Edit Event"
                                                            data-bs-toggle="tooltip">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </a>
                                                        <form action="{{ route('events.destroy', $encId) }}"
                                                            method="POST" class="d-inline delete-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm shadow-sm"
                                                                title="Move to Trash" data-bs-toggle="tooltip">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center py-5">
                                                <div class="text-muted">
                                                    <i class="bi bi-calendar-x display-1 d-block mb-3"></i>
                                                    <h5>No events found</h5>
                                                    @if (request()->hasAny(['search', 'eventType', 'status', 'from_date', 'to_date']))
                                                        <p>No events match your filters. Try adjusting them.</p>
                                                        <a href="{{ route('events.index', $trashed ? ['trashed' => 1] : []) }}"
                                                            class="btn btn-outline-primary">
                                                            <i class="bi bi-arrow-left me-1"></i>View All Events
                                                        </a>
                                                    @elseif (!$trashed)
                                                        <p>Get started by adding your first event.</p>
                                                        <a href="{{ route('events.create') }}" class="btn btn-primary">
                                                            <i class="bi bi-plus-circle me-1"></i>Add First Event
                                                        </a>
                                                    @else
                                                        <p>Trash is empty.</p>
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

        @if ($events->hasPages())
            <div class="row mt-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div class="text-muted mb-2 mb-md-0">
                            <span>Showing {{ $events->firstItem() }} to {{ $events->lastItem() }} of
                                {{ $events->total() }} results</span>
                        </div>
                        <nav aria-label="Events pagination">
                            <div class="pagination-wrapper">
                                {{ $events->links() }}
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
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Status switch posts its own form so the list reloads with the new state
            document.querySelectorAll('.status-toggle').forEach(function(toggle) {
                toggle.addEventListener('change', function() {
                    this.disabled = true;
                    document.getElementById('loadingOverlay').classList.remove('d-none');
                    this.closest('form').submit();
                });
            });

            document.querySelectorAll('.delete-form').forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    if (confirm(
                            '⚠️ Move this event to trash?\n\nIt will be hidden from the website but can be restored later.'
                        )) {
                        document.getElementById('loadingOverlay').classList.remove('d-none');
                        form.submit();
                    }
                });
            });

            document.querySelectorAll('.force-delete-form').forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    if (confirm(
                            '⚠️ Delete this event permanently?\n\nThe event, its gallery and the uploaded files will be removed. This cannot be undone.'
                        )) {
                        document.getElementById('loadingOverlay').classList.remove('d-none');
                        form.submit();
                    }
                });
            });

            setTimeout(function() {
                document.querySelectorAll('.alert').forEach(function(alert) {
                    new bootstrap.Alert(alert).close();
                });
            }, 5000);
        });
    </script>
@endsection
