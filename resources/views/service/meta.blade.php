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

        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-lg bg-gradient-seo text-white overflow-hidden">
                    <div class="card-body py-4 position-relative">
                        <!-- Background Pattern -->
                        <div class="header-pattern"></div>
                        <div class="row align-items-center position-relative">
                            <div class="col">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="header-icon me-3">
                                        <i class="bi bi-search fs-2"></i>
                                    </div>
                                    <div>
                                        <h3 class="mb-1 fw-bold">SEO Meta Management</h3>
                                        <p class="mb-0 opacity-75">Manage SEO metadata for better search engine visibility
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div
                                    class="stats-card bg-white text-black bg-opacity-20 backdrop-blur rounded-pill px-4 py-2">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-tags me-2 fs-5"></i>
                                        <div>
                                            <div class="fw-bold fs-5">{{ $meta->total() ?? 0 }}</div>
                                            <small class="opacity-75">Meta Entries</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-lg modern-card">
                    <!-- Search and Actions Bar -->
                    <div class="card-header bg-gradient-light border-0 py-4">
                        <div class="row g-3 align-items-center">
                            <div class="col-lg-8">
                                <form method="GET" action="{{ route('services.servicemeta') }}" class="search-form">
                                    <div class="input-group modern-input-group">
                                        <span class="input-group-text bg-white border-end-0">
                                            <i class="bi bi-search text-primary"></i>
                                        </span>
                                        <input type="text" name="search"
                                            class="form-control border-start-0 ps-0 modern-input"
                                            placeholder="Search by meta title, keywords, or description..."
                                            value="{{ request()->search }}" id="searchMeta">
                                        <button type="submit" class="btn btn-primary modern-btn px-4">
                                            <i class="bi bi-search me-1"></i>Search
                                        </button>
                                        @if (request()->has('search') && !empty(request()->search))
                                            <a href="{{ route('services.servicemeta') }}"
                                                class="btn btn-outline-secondary modern-btn">
                                                <i class="bi bi-arrow-clockwise me-1"></i>Clear
                                            </a>
                                        @endif
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-4 text-lg-end">
                                <a href="{{ route('services.meta_create') }}"
                                    class="btn btn-success modern-btn px-4 btn-lg">
                                    <i class="bi bi-plus-circle me-2"></i>Add New Meta
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Table Section -->
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 modern-table">
                                <thead class="table-dark modern-table-header">
                                    <tr>
                                        <th class="border-0 py-4 ps-4" style="width: 60px;">
                                            <i class="bi bi-hash me-1"></i>
                                        </th>
                                        <th class="border-0 py-4" style="width: 200px;">
                                            <i class="bi bi-gear-fill me-1"></i>Service
                                        </th>
                                        <th class="border-0 py-4" style="width: 150px;">
                                            <i class="bi bi-globe me-1"></i>Domain
                                        </th>
                                        <th class="border-0 py-4">
                                            <i class="bi bi-type-h1 me-1"></i>Meta Information
                                        </th>
                                        <th class="border-0 py-4 text-center" style="width: 180px;">
                                            <i class="bi bi-gear-wide-connected me-1"></i>Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $domainMap = [
                                            1 => ['name' => 'myitronline.com', 'color' => 'primary'],
                                            2 => ['name' => 'clarityefiling.com', 'color' => 'success'],
                                            3 => ['name' => 'taxa23.com', 'color' => 'warning'],
                                            4 => ['name' => 'eitrfiling.com', 'color' => 'info'],
                                        ];
                                    @endphp
                                    @forelse ($meta as $index => $item)
                                        <tr class="meta-row modern-row">
                                            <td class="ps-4">
                                                <div class="row-number">
                                                    {{ ($meta->currentPage() - 1) * $meta->perPage() + $index + 1 }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="service-info">
                                                    <div class="service-details">
                                                        <h6 class="service-name">{{ $item->serviceHeading ?? 'N/A' }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @php
                                                    $domain = $domainMap[$item->domain_id] ?? [
                                                        'name' => 'N/A',
                                                        'color' => 'secondary',
                                                    ];
                                                @endphp
                                                <span class="badge bg-{{ $domain['color'] }} domain-badge">
                                                    <i class="bi bi-globe me-1"></i>{{ $domain['name'] }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="meta-info">
                                                    <div class="meta-title">
                                                        <strong>Title:</strong>
                                                        <span class="text-truncate d-inline-block"
                                                            style="max-width: 300px;" title="{{ $item->metaTitle }}">
                                                            {{ $item->metaTitle }}
                                                        </span>
                                                    </div>
                                                    <div class="meta-keywords mt-1">
                                                        <strong>Keywords:</strong>
                                                        <span class="text-muted text-truncate d-inline-block"
                                                            style="max-width: 300px;" title="{{ $item->metaKeyword }}">
                                                            {{ $item->metaKeyword }}
                                                        </span>
                                                    </div>
                                                    <div class="meta-description mt-1">
                                                        <strong>Description:</strong>
                                                        <span class="text-muted text-truncate d-inline-block"
                                                            style="max-width: 300px;"
                                                            title="{{ $item->metaDescription }}">
                                                            {{ $item->metaDescription }}
                                                        </span>
                                                    </div>
                                                    @if ($item->tag)
                                                        <div class="meta-tags mt-2">
                                                            @foreach (explode(',', $item->tag) as $tag)
                                                                <span
                                                                    class="badge bg-light text-dark me-1">{{ trim($tag) }}</span>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="action-buttons">
                                                    <a href="{{ route('services.meta_edit', $item->id) }}"
                                                        class="btn btn-warning btn-sm modern-action-btn"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Edit Meta">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                    <form action="{{ route('services.meta_delete', $item->id) }}"
                                                        method="POST" class="d-inline delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-danger btn-sm modern-action-btn"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Delete Meta" data-meta-title="{{ $item->metaTitle }}">
                                                            <i class="bi bi-trash3"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5">
                                                <div class="empty-state">
                                                    <div class="empty-illustration">
                                                        <i class="bi bi-search display-1"></i>
                                                    </div>
                                                    <h4 class="empty-title">No Meta Entries Found</h4>
                                                    <p class="empty-description">
                                                        @if (request()->has('search') && !empty(request()->search))
                                                            No meta entries match your search criteria
                                                            "<strong>{{ request()->search }}</strong>".
                                                            <br>Try adjusting your search terms.
                                                        @else
                                                            You haven't created any SEO meta entries yet.
                                                            <br>Get started by creating your first meta entry.
                                                        @endif
                                                    </p>
                                                    <div class="empty-actions">
                                                        @if (!request()->has('search') || empty(request()->search))
                                                            <a href="{{ route('services.meta_create') }}"
                                                                class="btn btn-primary btn-lg modern-btn">
                                                                <i class="bi bi-plus-circle me-2"></i>Create Your First
                                                                Meta Entry
                                                            </a>
                                                        @else
                                                            <a href="{{ route('services.servicemeta') }}"
                                                                class="btn btn-outline-primary btn-lg modern-btn">
                                                                <i class="bi bi-arrow-left me-2"></i>View All Meta Entries
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

                    <!-- Pagination Footer -->
                    @if ($meta->hasPages())
                        <div class="card-footer bg-gradient-light border-0 py-4">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="pagination-info">
                                        <i class="bi bi-info-circle me-2"></i>
                                        Showing <strong>{{ $meta->firstItem() }}</strong> to
                                        <strong>{{ $meta->lastItem() }}</strong> of
                                        <strong>{{ $meta->total() }}</strong> results
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <nav class="d-flex justify-content-md-end justify-content-center mt-2 mt-md-0">
                                        <ul class="pagination mb-0 modern-pagination">
                                            @if ($meta->onFirstPage())
                                                <li class="page-item disabled">
                                                    <span class="page-link">
                                                        <i class="bi bi-chevron-left"></i>
                                                    </span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $meta->previousPageUrl() }}">
                                                        <i class="bi bi-chevron-left"></i>
                                                    </a>
                                                </li>
                                            @endif

                                            @for ($i = max(1, $meta->currentPage() - 2); $i <= min($meta->lastPage(), $meta->currentPage() + 2); $i++)
                                                <li class="page-item {{ $meta->currentPage() == $i ? 'active' : '' }}">
                                                    <a class="page-link"
                                                        href="{{ $meta->url($i) }}">{{ $i }}</a>
                                                </li>
                                            @endfor

                                            @if ($meta->hasMorePages())
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $meta->nextPageUrl() }}">
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
<script src="{{ asset('js/metablade.js') }}"></script>
@endsection
