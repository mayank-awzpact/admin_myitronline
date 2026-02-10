@extends('backend.app')
@section('content')
<div class="container-fluid py-4">
    {{-- Page Header with Gradient Background --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-lg" style="background: linear-gradient(135deg, #ff6b6b 0%, #feca57 100%);">
                <div class="card-body text-white py-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="bg-white text-black  bg-opacity-20 rounded-circle p-3 me-3">
                                <i class="bi bi-trophy fs-2"></i>
                            </div>
                            <div>
                                <h2 class="fw-bold mb-1"> Spin & Win Rewards</h2>
                                <p class="mb-0 opacity-75">Manage and track all spin wheel reward entries</p>
                            </div>
                        </div>
                        <div class="text-end">
                             <div class="bg-white text-black bg-opacity-20 rounded-lg p-3">
                                <h3 class="fw-bold mb-0" id="totalEntries">0</h3>
                                <small class="opacity-75">Total Entries</small>
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
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-lg-8 col-md-8">
                            <label for="searchInput" class="form-label fw-semibold text-muted">
                                <i class="bi bi-search me-1"></i>Search Entries
                            </label>
                            <div class="input-group shadow-sm">
                                <input type="text" class="form-control" id="searchInput"
                                       placeholder="Search by email or reward...">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <label for="eligibilityFilter" class="form-label fw-semibold text-muted">
                                <i class="bi bi-filter me-1"></i>Eligibility Status
                            </label>
                            <select class="form-select shadow-sm" id="eligibilityFilter">
                                <option value="">All Entries</option>
                                <option value="1">Eligible</option>
                                <option value="0">Not Eligible</option>
                            </select>
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
                         <button class="btn btn-sm btn-outline-secondary" onclick="clearFilters()">
                            <i class="bi bi-x-circle me-1"></i>Clear Filters
                        </button>
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
                                    <th class="py-3"><i class="bi bi-envelope me-1"></i>Email</th>
                                    <th class="py-3"><i class="bi bi-gift me-1"></i>Reward</th>
                                    <th class="py-3"><i class="bi bi-shield-check me-1"></i>Eligibility</th>
                                    <th class="py-3"><i class="bi bi-calendar me-1"></i>Entry Date</th>
                                </tr>
                            </thead>
                            <tbody id="spinTableBody">
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
                <nav aria-label="Spin entries pagination">
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
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</div>


{{-- Scripts --}}
<script>
document.addEventListener("DOMContentLoaded", function() {
    const allEntries = @json($spin_data);
    let currentPage = 1;
    const rowsPerPage = 10;
    let filteredData = [...allEntries];

    function showLoading() {
        document.getElementById('loadingOverlay').classList.remove('d-none');
    }

    function hideLoading() {
        document.getElementById('loadingOverlay').classList.add('d-none');
    }

    function applyFilters() {
        showLoading();

        setTimeout(() => {
            const searchQuery = document.getElementById("searchInput").value.toLowerCase().trim();
            const eligibilityFilter = document.getElementById("eligibilityFilter").value;

            filteredData = allEntries.filter(entry => {
                const matchesSearch = !searchQuery ||
                    (entry.email && entry.email.toLowerCase().includes(searchQuery)) ||
                    (entry.reward && entry.reward.toLowerCase().includes(searchQuery));

                const matchesEligibility = eligibilityFilter === '' ||
                    String(entry.is_eligible) === eligibilityFilter;

                return matchesSearch && matchesEligibility;
            });

            document.getElementById("filteredCount").innerHTML =
                `<i class="bi bi-list-ul me-1"></i>Showing <strong>${filteredData.length}</strong> results`;

            currentPage = 1;
            displayTable();
            hideLoading();
        }, 300);
    }

    function displayTable() {
        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        const paginatedData = filteredData.slice(start, end);
        const tbody = document.getElementById("spinTableBody");
        tbody.innerHTML = "";

        const showingFrom = filteredData.length > 0 ? start + 1 : 0;
        const showingTo = Math.min(end, filteredData.length);
        document.getElementById('paginationInfo').textContent =
            `Showing ${showingFrom} to ${showingTo} of ${filteredData.length} results`;

        if (paginatedData.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="5" class="text-center py-5">
                        <div class="text-muted">
                            <i class="bi bi-trophy display-1 d-block mb-3"></i>
                            <h5>No spin entries found</h5>
                            <p>Try adjusting your filters to see more results.</p>
                        </div>
                    </td>
                </tr>
            `;
            updatePagination();
            return;
        }

        paginatedData.forEach((entry, index) => {
            const createdAt = new Date(entry.created_at);
            const formattedDate = createdAt.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
            const formattedTime = createdAt.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });

            const eligibilityBadge = entry.is_eligible == 1
                ? '<span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2"><i class="bi bi-check-circle me-1"></i>Eligible</span>'
                : '<span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2"><i class="bi bi-x-circle me-1"></i>Not Eligible</span>';

            const rewardText = entry.reward || 'No Reward';
            const rewardBadge = `<span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 fw-medium">${rewardText}</span>`;

            tbody.innerHTML += `
                <tr class="text-center">
                    <td class="fw-bold">${start + index + 1}</td>
                    <td class="fw-semibold text-dark">${entry.email}</td>
                    <td>${rewardBadge}</td>
                    <td>${eligibilityBadge}</td>
                    <td class="text-muted">${formattedDate} at ${formattedTime}</td>
                </tr>
            `;
        });

        updatePagination();
    }

    // CORRECTED PAGINATION FUNCTION (Same as your first example)
    function updatePagination() {
        const totalPages = Math.ceil(filteredData.length / rowsPerPage);
        const pagination = document.getElementById("pagination");
        pagination.innerHTML = "";

        if (totalPages <= 1) {
            return;
        }

        const maxVisiblePages = 7;
        let startPage, endPage;

        if (totalPages <= maxVisiblePages) {
            startPage = 1;
            endPage = totalPages;
        } else {
            const halfVisible = Math.floor(maxVisiblePages / 2);
            if (currentPage <= halfVisible) {
                startPage = 1;
                endPage = maxVisiblePages;
            } else if (currentPage + halfVisible >= totalPages) {
                startPage = totalPages - maxVisiblePages + 1;
                endPage = totalPages;
            } else {
                startPage = currentPage - halfVisible;
                endPage = currentPage + halfVisible;
            }
        }

        pagination.innerHTML += `
            <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                <a class="page-link" href="#" onclick="changePage(${currentPage - 1})">Previous</a>
            </li>
        `;

        for (let i = startPage; i <= endPage; i++) {
            pagination.innerHTML += `
                <li class="page-item ${i === currentPage ? 'active' : ''}">
                    <a class="page-link" href="#" onclick="changePage(${i})">${i}</a>
                </li>
            `;
        }

        pagination.innerHTML += `
            <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                <a class="page-link" href="#" onclick="changePage(${currentPage + 1})">Next</a>
            </li>
        `;
    }

    function updateHeaderStats() {
         document.getElementById('totalEntries').textContent = allEntries.length.toLocaleString();
    }

    // Global functions
    window.changePage = function(page) {
        const totalPages = Math.ceil(filteredData.length / rowsPerPage);
        if (page < 1 || page > totalPages) return;
        currentPage = page;
        displayTable();
        document.querySelector('.table-responsive').scrollIntoView({ behavior: 'smooth' });
    };

    window.clearFilters = function() {
        document.getElementById("searchInput").value = '';
        document.getElementById("eligibilityFilter").value = '';
        applyFilters();
    };

    // Event listeners
    document.getElementById("searchInput").addEventListener("input", applyFilters);
    document.getElementById("eligibilityFilter").addEventListener("change", applyFilters);

    // Initial load
    updateHeaderStats();
    applyFilters();
});
</script>
@endsection
