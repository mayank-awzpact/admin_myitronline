@extends('backend.app')
@section('content')
<div class="container-fluid py-4">
    {{-- Page Header with Gradient Background --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-lg" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body text-white py-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="bg-white text-black bg-opacity-20 rounded-circle p-3 me-3">
                                <i class="bi bi-telephone fs-2"></i>
                            </div>
                            <div>
                                <h2 class="fw-bold mb-1">ECA Requests Management</h2>
                                <p class="mb-0 opacity-75">Manage and track all ECA request submissions</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Enhanced Filter Card --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-dark">
                            <i class="bi bi-funnel me-2 text-primary"></i>Search & Filter
                        </h5>
                        <button class="btn btn-sm btn-outline-primary d-md-none" type="button"
                                data-bs-toggle="collapse" data-bs-target="#filtersCollapse">
                            <i class="bi bi-sliders me-1"></i> Toggle Filters
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="collapse d-md-block" id="filtersCollapse">
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6">
                                <label for="searchInput" class="form-label fw-semibold text-muted">
                                    <i class="bi bi-search me-1"></i>Search Requests
                                </label>
                                <div class="input-group shadow-sm">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-search text-muted"></i>
                                    </span>
                                    <input type="text" class="form-control border-start-0" id="searchInput"
                                           placeholder="Search by name, email, phone, or URL...">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <label for="searchurl" class="form-label fw-semibold text-muted">
                                    <i class="bi bi-globe me-1"></i>Reference Domain
                                </label>
                                <select class="form-select shadow-sm" id="searchurl">
                                    <option value="">All Domains</option>
                                    <option value="myitronline.com">myitronline.com</option>
                                    <option value="eitrfiling.com">eitfiling.com</option>
                                    <option value="taxa23.com">taxa23.com</option>
                                    <option value="clarityefiling.com">clarityefiling.com</option>
                                    <option value="apnokaca.com">apnokaca.com</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Results Summary Card --}}
    <div class="row mb-3">
        <div class="col-12">
            <div class="card border-0 bg-light">
                <div class="card-body py-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <span id="filteredCount" class="text-muted fw-medium">
                            <i class="bi bi-list-ul me-1"></i>Showing 0 results
                        </span>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-outline-primary" onclick="refreshData()">
                                <i class="bi bi-arrow-clockwise me-1"></i>Refresh
                            </button>
                            <button class="btn btn-sm btn-outline-secondary" onclick="clearFilters()">
                                <i class="bi bi-x-circle me-1"></i>Clear Filters
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Enhanced Data Table --}}
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
                                    <th class="py-3"><i class="bi bi-telephone me-1"></i>Phone</th>
                                    <th class="py-3"><i class="bi bi-globe me-1"></i>Reference URL</th>
                                    {{-- <th class="py-3"><i class="bi bi-gear me-1"></i>Action</th> --}}
                                </tr>
                            </thead>
                            <tbody id="ecaTable">
                                <!-- Dynamic content will be loaded here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Enhanced Pagination --}}
    <div class="row mt-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="text-muted mb-2 mb-md-0">
                    <span id="paginationInfo">Showing 0 to 0 of 0 results</span>
                </div>
                <nav aria-label="ECA requests pagination">
                    <ul class="pagination mb-0" id="pagination">
                        <!-- Pagination will be generated dynamically -->
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

{{-- Loading Overlay --}}
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
    let ecarequests = @json($ecarequest);
    let currentPage = 1;
    const rowsPerPage = 10;
    let filteredECARequests = [...ecarequests];

    function showLoading() {
        document.getElementById('loadingOverlay').classList.remove('d-none');
    }

    function hideLoading() {
        document.getElementById('loadingOverlay').classList.add('d-none');
    }

    function extractDomainFromUrl(url) {
        if (!url) return "";
        try {
            return new URL(url).hostname.replace("www.", "");
        } catch {
            return "";
        }
    }

    function filterTable() {
        showLoading();

        setTimeout(() => {
            const searchQuery = document.getElementById("searchInput").value.toLowerCase().trim();
            const selectedDomain = document.getElementById("searchurl").value.toLowerCase();

            filteredECARequests = ecarequests.filter(request => {
                const domainFromUrl = extractDomainFromUrl(request.reference_url);
                const matchesDomain = !selectedDomain || (domainFromUrl && domainFromUrl === selectedDomain);

                const matchesQuery = !searchQuery ||
                    (request.uniqueId && request.uniqueId.toString().toLowerCase().includes(searchQuery)) ||
                    (request.name && request.name.toLowerCase().includes(searchQuery)) ||
                    (request.email && request.email.toLowerCase().includes(searchQuery)) ||
                    (request.phone_number && request.phone_number.includes(searchQuery)) ||
                    (request.reference_url && request.reference_url.toLowerCase().includes(searchQuery));

                return matchesQuery && matchesDomain;
            });

            document.getElementById("filteredCount").innerHTML =
                `<i class="bi bi-list-ul me-1"></i>Showing <strong>${filteredECARequests.length}</strong> results`;

            currentPage = 1;
            displayTable(currentPage);
            hideLoading();
        }, 300);
    }

    function displayTable(page) {
        currentPage = page;
        const start = (page - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        const paginatedRequests = filteredECARequests.slice(start, end);
        const tbody = document.getElementById("ecaTable");
        tbody.innerHTML = "";

        // Update pagination info
        const showingFrom = filteredECARequests.length > 0 ? start + 1 : 0;
        const showingTo = Math.min(end, filteredECARequests.length);
        document.getElementById('paginationInfo').textContent =
            `Showing ${showingFrom} to ${showingTo} of ${filteredECARequests.length} results`;

        if (paginatedRequests.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <div class="text-muted">
                            <i class="bi bi-telephone display-1 d-block mb-3"></i>
                            <h5>No ECA requests found</h5>
                            <p>Try adjusting your filters to see more results.</p>
                        </div>
                    </td>
                </tr>
            `;
            updatePagination();
            return;
        }

        paginatedRequests.forEach((request, index) => {
            const rowId = `collapseRow${start + index}`;
            const serialNumber = start + index + 1;
            const domain = extractDomainFromUrl(request.reference_url);

            tbody.innerHTML += `
                <tr class="text-center">
                    <td class="fw-bold text-primary">${serialNumber}</td>
                    <td><span class="request-name">${request.name || 'N/A'}</span></td>
                    <td class="text-muted small" style="word-break: break-word;">${request.email || 'N/A'}</td>
                    <td class="fw-medium">${request.phone_number || 'N/A'}</td>
                    <td class="text-start">
                        <div class="d-flex flex-column">
                            <a href="${request.reference_url || '#'}" target="_blank" class="url-link text-truncate"
                               style="max-width: 200px;" title="${request.reference_url || 'N/A'}">
                                ${request.reference_url || 'N/A'}
                            </a>
                            ${domain ? `<span class="domain-badge mt-1 align-self-start">${domain}</span>` : ''}
                        </div>
                    </td>
                </tr>
                <tr class="collapse collapse-row" id="${rowId}">
                    <td colspan="6">
                        <div class="card border-0 m-3">
                            <div class="card-body">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <h6 class="text-primary mb-3">
                                            <i class="bi bi-info-circle me-2"></i>Request Details
                                        </h6>
                                        <div class="row g-2">
                                            <div class="col-sm-4"><strong>Unique ID:</strong></div>
                                            <div class="col-sm-8"><code>${request.uniqueId || 'N/A'}</code></div>
                                            <div class="col-sm-4"><strong>Name:</strong></div>
                                            <div class="col-sm-8">${request.name || 'N/A'}</div>
                                            <div class="col-sm-4"><strong>Email:</strong></div>
                                            <div class="col-sm-8">
                                                <a href="mailto:${request.email}" class="text-decoration-none">
                                                    ${request.email || 'N/A'}
                                                </a>
                                            </div>
                                            <div class="col-sm-4"><strong>Phone:</strong></div>
                                            <div class="col-sm-8">
                                                <a href="tel:${request.phone_number}" class="text-decoration-none">
                                                    ${request.phone_number || 'N/A'}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="text-primary mb-3">
                                            <i class="bi bi-globe me-2"></i>Reference Information
                                        </h6>
                                        <div class="row g-2">
                                            <div class="col-sm-4"><strong>Full URL:</strong></div>
                                            <div class="col-sm-8">
                                                <a href="${request.reference_url}" target="_blank" class="url-link">
                                                    ${request.reference_url || 'N/A'}
                                                </a>
                                            </div>
                                            <div class="col-sm-4"><strong>Domain:</strong></div>
                                            <div class="col-sm-8">
                                                <span class="domain-badge">${domain || 'N/A'}</span>
                                            </div>
                                            <div class="col-sm-4"><strong>Created:</strong></div>
                                            <div class="col-sm-8">${request.created_at ? new Date(request.created_at).toLocaleDateString() : 'N/A'}</div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-3">
                                <div class="d-flex justify-content-end gap-2">
                                    <button class="btn btn-sm btn-outline-primary" onclick="contactRequest('${request.email}', '${request.phone_number}')">
                                        <i class="bi bi-telephone me-1"></i>Contact
                                    </button>
                                    <button class="btn btn-sm btn-outline-success" onclick="viewRequest('${request.uniqueId}')">
                                        <i class="bi bi-eye me-1"></i>View Details
                                    </button>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            `;
        });

        updatePagination();
    }

    function updatePagination() {
        const totalPages = Math.ceil(filteredECARequests.length / rowsPerPage);
        const maxVisiblePages = 10;
        let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
        let endPage = startPage + maxVisiblePages - 1;

        if (endPage > totalPages) {
            endPage = totalPages;
            startPage = Math.max(1, endPage - maxVisiblePages + 1);
        }

        let paginationHTML = "";

        if (totalPages <= 1) {
            document.getElementById("pagination").innerHTML = "";
            return;
        }

        // Previous button
        paginationHTML += `
            <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                <a class="page-link" href="#" onclick="changePage(${currentPage - 1})" ${currentPage === 1 ? 'tabindex="-1"' : ''}>
                    Previous
                </a>
            </li>
        `;

        // Page numbers
        for (let i = startPage; i <= endPage; i++) {
            paginationHTML += `
                <li class="page-item ${i === currentPage ? 'active' : ''}">
                    <a class="page-link" href="#" onclick="changePage(${i})">${i}</a>
                </li>
            `;
        }

        // Next button
        paginationHTML += `
            <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                <a class="page-link" href="#" onclick="changePage(${currentPage + 1})" ${currentPage === totalPages ? 'tabindex="-1"' : ''}>
                    Next
                </a>
            </li>
        `;

        document.getElementById("pagination").innerHTML = paginationHTML;
    }

    // Global functions
    window.changePage = function(page) {
        const totalPages = Math.ceil(filteredECARequests.length / rowsPerPage);
        if (page < 1 || page > totalPages) return;

        currentPage = page;
        displayTable(page);

        // Smooth scroll to top of table
        document.querySelector('.table-responsive').scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    };

    window.refreshData = function() {
        showLoading();
        setTimeout(() => {
            filteredECARequests = [...ecarequests];
            displayTable(1);
            hideLoading();
        }, 500);
    };

    window.clearFilters = function() {
        document.getElementById("searchInput").value = '';
        document.getElementById("searchurl").value = '';
        filterTable();
    };

    window.contactRequest = function(email, phone) {
        const message = `Contact options for this request:\n\nEmail: ${email}\nPhone: ${phone}`;
        alert(message);
        // Implement contact functionality
    };

    window.viewRequest = function(uniqueId) {
        alert(`View request details for ID: ${uniqueId}`);
        // Implement view request functionality
    };

    // Event listeners
    document.getElementById("searchInput").addEventListener("input", filterTable);
    document.getElementById("searchurl").addEventListener("change", filterTable);

    // Initial load
    displayTable(1);
});
</script>
@endsection
