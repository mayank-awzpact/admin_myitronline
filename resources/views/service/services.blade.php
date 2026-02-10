@extends('backend.app')

@section('content')
    <div class="container-fluid py-4">
        <!-- Success/Error Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <div class="alert-icon me-3">
                        <i class="bi bi-check-circle-fill fs-4 text-success"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="alert-heading mb-1 fw-bold">Success!</h6>
                        <p class="mb-0">{{ session('success') }}</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <div class="alert-icon me-3">
                        <i class="bi bi-exclamation-triangle-fill fs-4 text-danger"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="alert-heading mb-1 fw-bold">Error!</h6>
                        <p class="mb-0">{{ session('error') }}</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-warning alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <div class="alert-icon me-3">
                        <i class="bi bi-exclamation-circle-fill fs-4 text-warning"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="alert-heading mb-1 fw-bold">Validation Errors!</h6>
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-lg bg-gradient-primary text-white overflow-hidden">
                    <div class="card-body py-4 position-relative">
                        <!-- Background Pattern -->
                        <div class="header-pattern"></div>
                        <div class="row align-items-center position-relative">
                            <div class="col">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="header-icon me-3">
                                        <i class="bi bi-gear-fill fs-2"></i>
                                    </div>
                                    <div>
                                        <h3 class="mb-1 fw-bold">Services Management</h3>
                                        <p class="mb-0 opacity-75">Manage and organize your services efficiently</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div
                                    class="stats-card bg-white text-black bg-opacity-20 backdrop-blur rounded-pill px-4 py-2">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-collection me-2 fs-5"></i>
                                        <div>
                                            <div class="fw-bold fs-5">{{ $services->total() ?? 0 }}</div>
                                            <small class="opacity-75">Total Services</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-lg modern-card">
                    <div class="card-header bg-gradient-light border-0 py-4">
                        <div class="row g-3 align-items-center">
                            <div class="col-lg-8">
                                <form method="GET" action="{{ route('services.index') }}" class="search-form">
                                    <div class="input-group modern-input-group">
                                        <span class="input-group-text bg-white border-end-0">
                                            <i class="bi bi-search text-primary"></i>
                                        </span>
                                        <input type="text" name="search"
                                            class="form-control border-start-0 ps-0 modern-input"
                                            placeholder="Search services by name..." value="{{ request()->search }}"
                                            id="searchService">
                                        <button type="submit" class="btn btn-primary modern-btn px-4">
                                            <i class="bi bi-search me-1"></i>Search
                                        </button>
                                        @if (request()->has('search') && !empty(request()->search))
                                            <a href="{{ route('services.index') }}"
                                                class="btn btn-outline-secondary modern-btn">
                                                <i class="bi bi-arrow-clockwise me-1"></i>Clear
                                            </a>
                                        @endif
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-4 text-lg-end">
                                <a href="{{ route('services.create') }}" class="btn btn-success modern-btn px-4 btn-lg">
                                    <i class="bi bi-plus-circle me-2"></i>Add New Service
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 modern-table">
                                <thead class="table-dark modern-table-header">
                                    <tr>
                                        <th class="border-0 py-4 ps-4" style="width: 80px;">
                                            <i class="bi bi-hash me-1"></i>#
                                        </th>
                                        <th class="border-0 py-4">
                                            <i class="bi bi-tag-fill me-1"></i>Service Details
                                        </th>
                                        <th class="border-0 py-4" style="width: 200px;">
                                            <i class="bi bi-calendar3 me-1"></i>Created On
                                        </th>
                                        <th class="border-0 py-4 text-center" style="width: 200px;">
                                            <i class="bi bi-gear-wide-connected me-1"></i>Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($services as $index => $service)
                                        <tr class="service-row modern-row">
                                            <td class="ps-4">
                                                <div class="row-number">
                                                    {{ ($services->currentPage() - 1) * $services->perPage() + $index + 1 }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="service-info">
                                                    <div class="service-avatar">
                                                        <i class="bi bi-gear-fill"></i>
                                                    </div>
                                                    <div class="service-details">
                                                        <h6 class="service-name">{{ $service->serviceName }}</h6>

                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="date-info">
                                                    <div class="date-primary">
                                                        {{ \Carbon\Carbon::parse($service->createdOn)->format('M d, Y') }}
                                                    </div>
                                                    <div class="date-secondary">
                                                        {{ \Carbon\Carbon::parse($service->createdOn)->format('h:i A') }}
                                                    </div>
                                                    <div class="date-relative">
                                                        {{ \Carbon\Carbon::parse($service->createdOn)->diffForHumans() }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="action-buttons">
                                                    <a href="{{ route('services.edit', Crypt::encryptString($service->uniqueId)) }}"
                                                        class="btn btn-warning btn-sm modern-action-btn"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Edit Service">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                    <form
                                                        action="{{ route('services.destroy', Crypt::encryptString($service->uniqueId)) }}"
                                                        method="POST" class="d-inline delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-danger btn-sm modern-action-btn"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Delete Service"
                                                            data-service-name="{{ $service->serviceName }}">
                                                            <i class="bi bi-trash3"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-5">
                                                <div class="empty-state">
                                                    <div class="empty-illustration">
                                                        <i class="bi bi-inbox display-1"></i>
                                                    </div>
                                                    <h4 class="empty-title">No Services Found</h4>
                                                    <p class="empty-description">
                                                        @if (request()->has('search') && !empty(request()->search))
                                                            No services match your search criteria
                                                            "<strong>{{ request()->search }}</strong>".
                                                            <br>Try adjusting your search terms.
                                                        @else
                                                            You haven't created any services yet.
                                                            <br>Get started by creating your first service.
                                                        @endif
                                                    </p>
                                                    <div class="empty-actions">
                                                        @if (!request()->has('search') || empty(request()->search))
                                                            <a href="{{ route('services.create') }}"
                                                                class="btn btn-primary btn-lg modern-btn">
                                                                <i class="bi bi-plus-circle me-2"></i>Create Your First
                                                                Service
                                                            </a>
                                                        @else
                                                            <a href="{{ route('services.index') }}"
                                                                class="btn btn-outline-primary btn-lg modern-btn">
                                                                <i class="bi bi-arrow-left me-2"></i>View All Services
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if ($services->hasPages())
                        <div class="card-footer bg-gradient-light border-0 py-4">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="pagination-info">
                                        <i class="bi bi-info-circle me-2"></i>
                                        Showing <strong>{{ $services->firstItem() }}</strong> to
                                        <strong>{{ $services->lastItem() }}</strong> of
                                        <strong>{{ $services->total() }}</strong> results
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <nav class="d-flex justify-content-md-end justify-content-center mt-2 mt-md-0">
                                        <ul class="pagination mb-0 modern-pagination">
                                            @if ($services->onFirstPage())
                                                <li class="page-item disabled">
                                                    <span class="page-link">
                                                        <i class="bi bi-chevron-left"></i>
                                                    </span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $services->previousPageUrl() }}">
                                                        <i class="bi bi-chevron-left"></i>
                                                    </a>
                                                </li>
                                            @endif

                                            @for ($i = max(1, $services->currentPage() - 2); $i <= min($services->lastPage(), $services->currentPage() + 2); $i++)
                                                <li
                                                    class="page-item {{ $services->currentPage() == $i ? 'active' : '' }}">
                                                    <a class="page-link"
                                                        href="{{ $services->url($i) }}">{{ $i }}</a>
                                                </li>
                                            @endfor

                                            @if ($services->hasMorePages())
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $services->nextPageUrl() }}">
                                                        <i class="bi bi-chevron-right"></i>
                                                    </a>
                                                </li>
                                            @else
                                                <li class="page-item disabled">
                                                    <span class="page-link">
                                                        <i class="bi bi-chevron-right"></i>
                                                    </span>
                                                </li>
                                            @endif
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>



    <script src="{{ asset('js/servicesindex.js') }}"></script>
@endsection
