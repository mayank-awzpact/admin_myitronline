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
                                <i class="bi bi-file-earmark-text-fill fs-2"></i>
                            </div>
                            <div>
                                <h2 class="fw-bold mb-1">Form-16 Payment Orders</h2>
                                <p class="mb-0 opacity-75">Manage and track Form-16 payment transactions</p>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="bg-white text-black bg-opacity-20 rounded-lg p-3">
                                <h3 class="fw-bold mb-0" id="totalOrders">0</h3>
                                <small class="opacity-75">Total Orders</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Statistics Cards --}}
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 stats-card success-card">
                <div class="card-body text-center">
                    <div class="bg-success bg-opacity-10 rounded-circle p-3 d-inline-flex mb-3">
                        <i class="bi bi-check-circle-fill fs-4 text-success"></i>
                    </div>
                    <h4 class="fw-bold mb-1 text-success" id="successTotal">0</h4>
                    <small class="text-muted">Successful Orders</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 stats-card pending-card">
                <div class="card-body text-center">
                    <div class="bg-warning bg-opacity-10 rounded-circle p-3 d-inline-flex mb-3">
                        <i class="bi bi-clock-history fs-4 text-warning"></i>
                    </div>
                    <h4 class="fw-bold mb-1 text-warning" id="pendingTotal">0</h4>
                    <small class="text-muted">Pending Orders</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 stats-card failed-card">
                <div class="card-body text-center">
                    <div class="bg-danger bg-opacity-10 rounded-circle p-3 d-inline-flex mb-3">
                        <i class="bi bi-x-circle-fill fs-4 text-danger"></i>
                    </div>
                    <h4 class="fw-bold mb-1 text-danger" id="failedTotal">0</h4>
                    <small class="text-muted">Failed Orders</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 stats-card revenue-card">
                <div class="card-body text-center">
                    <div class="bg-primary bg-opacity-10 rounded-circle p-3 d-inline-flex mb-3">
                        <i class="bi bi-currency-rupee fs-4 text-primary"></i>
                    </div>
                    <h4 class="fw-bold mb-1 text-primary" id="totalRevenue">₹0</h4>
                    <small class="text-muted">Total Revenue</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Enhanced Filter Card --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm filter-card">
                <div class="card-header bg-light border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-dark">
                            <i class="bi bi-funnel me-2 text-primary"></i>Advanced Filters
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
                            <div class="col-lg-2 col-md-3 col-sm-6">
                                <label for="statusFilter" class="form-label fw-semibold text-muted">
                                    <i class="bi bi-check-circle me-1"></i>Payment Status
                                </label>
                                <select class="form-select shadow-sm" id="statusFilter">
                                    <option value="">All Status</option>
                                    <option value="1">Success</option>
                                    <option value="0">Pending</option>
                                    <option value="2">Failed</option>
                                </select>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <label for="serviceType" class="form-label fw-semibold text-muted">
                                    <i class="bi bi-gear me-1"></i>Service Type
                                </label>
                                <select class="form-select shadow-sm" id="serviceType">
                                    <option value="">All Services</option>
                                    <option value="Form16 Payment">Form16 Payment</option>
                                    <option value="Multiple Form-16 Submission">Multiple Form-16 Submission</option>
                                    <option value="form16-itr1">Form16-ITR1</option>
                                    <option value="form16-itr2">Form16-ITR2</option>
                                </select>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6">
                                <label for="searchurl" class="form-label fw-semibold text-muted">
                                    <i class="bi bi-globe me-1"></i>Domain
                                </label>
                                <select class="form-select shadow-sm" id="searchurl">
                                    <option value="">All Domains</option>
                                    <option value="myitronline.com">myitronline.com</option>
                                    <option value="eitrfiling.com">eitrfiling.com</option>
                                    <option value="clarityefiling.in">clarityefiling.in</option>
                                </select>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <label for="searchInput" class="form-label fw-semibold text-muted">
                                    <i class="bi bi-search me-1"></i>Search Orders
                                </label>
                                <div class="input-group shadow-sm">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-search text-muted"></i>
                                    </span>
                                    <input type="text" class="form-control border-start-0" id="searchInput"
                                           placeholder="Search name, email, order ID...">
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-6 col-sm-6">
                                <label class="form-label fw-semibold text-muted">Export</label>
                                <div class="d-flex gap-2">
                                    <button id="downloadCsvBtn" class="btn btn-success shadow-sm flex-fill"
                                            title="Download CSV" data-bs-toggle="tooltip">
                                        <i class="bi bi-file-earmark-spreadsheet"></i>
                                    </button>
                                    <button id="downloadPdfBtn" class="btn btn-danger shadow-sm flex-fill"
                                            title="Download PDF" data-bs-toggle="tooltip">
                                        <i class="bi bi-file-earmark-pdf"></i>
                                    </button>
                                </div>
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
                        <div class="d-flex gap-3">
                            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2">
                                <i class="bi bi-check-circle-fill me-1"></i>Success: <span id="successCount">0</span>
                            </span>
                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-2">
                                <i class="bi bi-clock-history me-1"></i>Pending: <span id="pendingCount">0</span>
                            </span>
                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2">
                                <i class="bi bi-x-circle-fill me-1"></i>Failed: <span id="failedCount">0</span>
                            </span>
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
                                    <th class="py-3"><i class="bi bi-currency-rupee me-1"></i>Amount</th>
                                    <th class="py-3"><i class="bi bi-credit-card me-1"></i>Gateway</th>
                                    <th class="py-3"><i class="bi bi-check-circle me-1"></i>Status</th>
                                    <th class="py-3"><i class="bi bi-gear me-1"></i>Action</th>
                                </tr>
                            </thead>
                            <tbody id="ordersTableBody">
                                <!-- Dynamic content will be loaded here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Enhanced Pagination WITHOUT Ellipsis --}}
    <div class="row mt-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="text-muted mb-2 mb-md-0">
                    <span id="paginationInfo">Showing 0 to 0 of 0 results</span>
                </div>
                <nav aria-label="Form-16 Orders pagination">
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

{{-- Custom Styles --}}


{{-- Scripts --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    const orders = @json($orders);
    let currentPage = 1;
    const rowsPerPage = 10;
    let filteredOrders = [...orders];

    // Update statistics
    updateStatistics();

    function updateStatistics() {
        document.getElementById('totalOrders').textContent = orders.length.toLocaleString();

        const successOrders = orders.filter(order => String(order.paymentStatus) === "1");
        const pendingOrders = orders.filter(order => String(order.paymentStatus) === "0");
        const failedOrders = orders.filter(order => String(order.paymentStatus) === "2");

        document.getElementById('successTotal').textContent = successOrders.length.toLocaleString();
        document.getElementById('pendingTotal').textContent = pendingOrders.length.toLocaleString();
        document.getElementById('failedTotal').textContent = failedOrders.length.toLocaleString();

        // Calculate total revenue
        const totalRevenue = successOrders.reduce((sum, order) => {
            const amount = parseFloat(order.net_amount) || 0;
            return sum + amount;
        }, 0);

        document.getElementById('totalRevenue').textContent = '₹' + totalRevenue.toLocaleString('en-IN');
    }

    const cleanAmount = rawAmount => {
        if (!rawAmount) return "0";
        let cleaned = String(rawAmount).replace(/[^\d.]/g, '');
        const firstDot = cleaned.indexOf('.');
        if (firstDot !== -1) {
            cleaned = cleaned.slice(0, firstDot + 1) + cleaned.slice(firstDot + 1).replace(/\./g, '');
        }
        let num = parseFloat(cleaned);
        return isNaN(num) ? "0" : num.toLocaleString('en-IN');
    };

    function getStatusBadge(status) {
        switch (status) {
            case "1":
                return '<span class="badge bg-success px-3 py-2 rounded-pill"><i class="bi bi-check-circle-fill me-1"></i>Success</span>';
            case "2":
                return '<span class="badge bg-danger px-3 py-2 rounded-pill"><i class="bi bi-x-circle-fill me-1"></i>Failed</span>';
            default:
                return '<span class="badge bg-warning px-3 py-2 rounded-pill"><i class="bi bi-clock-history me-1"></i>Pending</span>';
        }
    }

    function getStatusBadgeText(status) {
        switch (status) {
            case "1": return "Success";
            case "2": return "Failed";
            default: return "Pending";
        }
    }

    function getGatewayBadge(gateway) {
        if (!gateway || gateway.trim() === '' || gateway === 'N/A') {
            return '<span class="badge bg-light text-dark px-3 py-2">N/A</span>';
        }
        return `<span class="badge bg-info text-white px-3 py-2">${gateway}</span>`;
    }

    function extractDomainFromUrl(url) {
        try {
            return new URL(url).hostname;
        } catch {
            return '';
        }
    }

    function updateStatusCounts() {
        const successCount = filteredOrders.filter(order => String(order.paymentStatus) === "1").length;
        const pendingCount = filteredOrders.filter(order => String(order.paymentStatus) === "0").length;
        const failedCount = filteredOrders.filter(order => String(order.paymentStatus) === "2").length;

        document.getElementById('successCount').textContent = successCount;
        document.getElementById('pendingCount').textContent = pendingCount;
        document.getElementById('failedCount').textContent = failedCount;
    }

    function showLoading() {
        document.getElementById('loadingOverlay').classList.remove('d-none');
    }

    function hideLoading() {
        document.getElementById('loadingOverlay').classList.add('d-none');
    }

    function applyFilters() {
        showLoading();

        setTimeout(() => {
            const status = document.getElementById("statusFilter").value;
            const service = document.getElementById("serviceType").value.toLowerCase();
            const domain = document.getElementById("searchurl").value;
            const searchText = document.getElementById("searchInput").value.toLowerCase();

            filteredOrders = orders.filter(order => {
                const orderStatus = String(order.paymentStatus);
                const orderService = (order.orderFromName ?? '').toLowerCase();
                const orderDomain = extractDomainFromUrl(order.serviceUrl);
                const name = (order.first_name ?? order.name ?? '').toLowerCase();
                const email = (order.form16_email ?? order.email ?? '').toLowerCase();
                const orderId = String(order.orderId ?? '');

                return (
                    (status === '' || orderStatus === status) &&
                    (service === '' || orderService.includes(service)) &&
                    (domain === '' || orderDomain.includes(domain)) &&
                    (name.includes(searchText) || email.includes(searchText) || orderId.includes(searchText))
                );
            });

            document.getElementById("filteredCount").innerHTML =
                `<i class="bi bi-list-ul me-1"></i>Showing <strong>${filteredOrders.length}</strong> results`;

            updateStatusCounts();
            currentPage = 1;
            displayTable();
            hideLoading();
        }, 300);
    }

    function displayTable() {
        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        const paginatedOrders = filteredOrders.slice(start, end);
        const tbody = document.getElementById("ordersTableBody");
        tbody.innerHTML = "";

        // Update pagination info
        const showingFrom = filteredOrders.length > 0 ? start + 1 : 0;
        const showingTo = Math.min(end, filteredOrders.length);
        document.getElementById('paginationInfo').textContent =
            `Showing ${showingFrom} to ${showingTo} of ${filteredOrders.length} results`;

        if (paginatedOrders.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <div class="text-muted">
                            <i class="bi bi-file-earmark-text display-1 d-block mb-3"></i>
                            <h5>No Form-16 orders found</h5>
                            <p>Try adjusting your filters to see more results.</p>
                        </div>
                    </td>
                </tr>
            `;
            updatePagination();
            return;
        }

        paginatedOrders.forEach((order, index) => {
            const rowId = `collapseRow${start + index}`;
            const displayEmail = order.form16_email ?? order.email ?? 'null';

            tbody.innerHTML += `
                <tr class="text-center">
                    <td class="fw-bold text-primary">${start + index + 1}</td>
                    <td class="fw-semibold">${order.first_name ?? order.name}</td>
                    <td class="text-muted">${displayEmail}</td>
                    <td class="fw-bold text-success">₹${cleanAmount(order.net_amount)}</td>
                    <td>${getGatewayBadge(order.paymentGateway)}</td>
                    <td>${getStatusBadge(String(order.paymentStatus))}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse"
                                data-bs-target="#${rowId}" title="View Details">
                            <i class="bi bi-eye"></i>
                        </button>
                    </td>
                </tr>
                <tr class="collapse collapse-row" id="${rowId}">
                    <td colspan="7">
                        <div class="card border-0 m-3">
                            <div class="card-body">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <h6 class="text-primary mb-3"><i class="bi bi-info-circle me-2"></i>Personal Details</h6>
                                        <div class="row g-2">
                                            <div class="col-sm-4"><strong>Service:</strong></div>
                                            <div class="col-sm-8">${order.orderFromName}</div>
                                            <div class="col-sm-4"><strong>Order ID:</strong></div>
                                            <div class="col-sm-8"><code>${order.orderId}</code></div>
                                            <div class="col-sm-4"><strong>Domain:</strong></div>
                                            <div class="col-sm-8">${extractDomainFromUrl(order.serviceUrl)}</div>
                                            <div class="col-sm-4"><strong>Phone:</strong></div>
                                            <div class="col-sm-8"><a href="tel:${order.phone}" class="text-decoration-none">${order.phone}</a></div>
                                            <div class="col-sm-4"><strong>Gender:</strong></div>
                                            <div class="col-sm-8">${order.gender ?? 'N/A'}</div>
                                            <div class="col-sm-4"><strong>Address:</strong></div>
                                            <div class="col-sm-8">${order.full_address ?? 'N/A'}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="text-primary mb-3"><i class="bi bi-bank me-2"></i>Payment & Banking Details</h6>
                                        <div class="row g-2">
                                            <div class="col-sm-4"><strong>Sub Total:</strong></div>
                                            <div class="col-sm-8 text-success fw-bold">₹${cleanAmount(order.amount)}</div>
                                            <div class="col-sm-4"><strong>Tax:</strong></div>
                                            <div class="col-sm-8 text-warning fw-bold">₹${cleanAmount(order.tax_amount ?? 0)}</div>
                                            <div class="col-sm-4"><strong>Total:</strong></div>
                                            <div class="col-sm-8 text-primary fw-bold">₹${cleanAmount(order.net_amount ?? 0)}</div>
                                            <div class="col-sm-4"><strong>IFSC:</strong></div>
                                            <div class="col-sm-8"><code>${order.ifsc_code ?? 'N/A'}</code></div>
                                            <div class="col-sm-4"><strong>Bank:</strong></div>
                                            <div class="col-sm-8">${order.bank_name ?? 'N/A'}</div>
                                            <div class="col-sm-4"><strong>Account Type:</strong></div>
                                            <div class="col-sm-8">${order.account_type ?? 'N/A'}</div>
                                            <div class="col-sm-4"><strong>Date:</strong></div>
                                            <div class="col-sm-8">${order.createdOn}</div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-3">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <h6 class="text-success mb-2"><i class="bi bi-receipt me-2"></i>Invoice</h6>
                                        ${order.invoicePath ?
                                            `<a href="/storage/${order.invoicePath}" class="btn btn-sm btn-outline-success" target="_blank">
                                                <i class="bi bi-download me-1"></i>Download Invoice
                                            </a>` :
                                            '<span class="text-muted">N/A</span>'
                                        }
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="text-danger mb-2"><i class="bi bi-file-pdf me-2"></i>PDF Files</h6>
                                        <div class="d-flex flex-wrap gap-1">
                                            ${(() => {
                                                try {
                                                    const paths = typeof order.pdfFilePath === 'string' ? JSON.parse(order.pdfFilePath) : order.pdfFilePath;
                                                    if (Array.isArray(paths)) {
                                                        return paths.length
                                                            ? paths.map((url, idx) =>
                                                                `<a href="${url}" class="btn btn-sm btn-outline-danger" target="_blank">
                                                                    <i class="bi bi-file-pdf me-1"></i>PDF ${idx + 1}
                                                                </a>`
                                                            ).join(' ')
                                                            : '<span class="text-muted">N/A</span>';
                                                    }
                                                    if (typeof paths === 'string') {
                                                        return `<a href="${paths}" class="btn btn-sm btn-outline-danger" target="_blank">
                                                            <i class="bi bi-file-pdf me-1"></i>Download PDF
                                                        </a>`;
                                                    }
                                                    return '<span class="text-muted">N/A</span>';
                                                } catch (e) {
                                                    return order.pdfFilePath
                                                        ? `<a href="${order.pdfFilePath}" class="btn btn-sm btn-outline-danger" target="_blank">
                                                            <i class="bi bi-file-pdf me-1"></i>Download PDF
                                                        </a>`
                                                        : '<span class="text-muted">N/A</span>';
                                                }
                                            })()}
                                        </div>
                                    </div>
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
        const totalPages = Math.ceil(filteredOrders.length / rowsPerPage);
        const pagination = document.getElementById("pagination");
        pagination.innerHTML = "";

        if (totalPages <= 1) {
            return;
        }

        // Maximum number of page links to show
        const maxVisiblePages = 10;
        let startPage, endPage;

        if (totalPages <= maxVisiblePages) {
            // Show all pages if total pages is less than or equal to max visible
            startPage = 1;
            endPage = totalPages;
        } else {
            // Calculate start and end pages
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

        // Previous button
        pagination.innerHTML += `
            <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                <a class="page-link" href="#" onclick="changePage(${currentPage - 1})" ${currentPage === 1 ? 'tabindex="-1"' : ''}>
                    Previous
                </a>
            </li>
        `;

        // Page numbers - NO ELLIPSIS, just show the calculated range
        for (let i = startPage; i <= endPage; i++) {
            pagination.innerHTML += `
                <li class="page-item ${i === currentPage ? 'active' : ''}">
                    <a class="page-link" href="#" onclick="changePage(${i})">${i}</a>
                </li>
            `;
        }

        // Next button
        pagination.innerHTML += `
            <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                <a class="page-link" href="#" onclick="changePage(${currentPage + 1})" ${currentPage === totalPages ? 'tabindex="-1"' : ''}>
                    Next
                </a>
            </li>
        `;
    }

    // Global function for pagination
    window.changePage = function(page) {
        const totalPages = Math.ceil(filteredOrders.length / rowsPerPage);
        if (page < 1 || page > totalPages) return;

        currentPage = page;
        displayTable();

        // Smooth scroll to top of table
        document.querySelector('.table-responsive').scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    };

    // Event listeners
    document.getElementById("statusFilter").addEventListener("change", applyFilters);
    document.getElementById("serviceType").addEventListener("change", applyFilters);
    document.getElementById("searchurl").addEventListener("change", applyFilters);
    document.getElementById("searchInput").addEventListener("input", applyFilters);

    // CSV Export
    document.getElementById("downloadCsvBtn").addEventListener("click", () => {
        if (filteredOrders.length === 0) {
            alert("No data to export.");
            return;
        }

        showLoading();

        setTimeout(() => {
            const csvRows = [];
            const headers = ["#", "Name", "Email", "Amount", "Gateway", "Status", "Service", "Phone", "Order ID"];
            csvRows.push(headers.join(","));

            filteredOrders.forEach((order, i) => {
                const row = [
                    i + 1,
                    `"${order.first_name ?? order.name}"`,
                    `"${order.form16_email ?? order.email ?? 'null'}"`,
                    `"${cleanAmount(order.net_amount)}"`,
                    `"${order.paymentGateway ?? 'N/A'}"`,
                    `"${getStatusBadgeText(String(order.paymentStatus))}"`,
                    `"${order.orderFromName}"`,
                    `"${order.phone}"`,
                    `"${order.orderId}"`
                ];
                csvRows.push(row.join(","));
            });

            const blob = new Blob([csvRows.join("\n")], { type: "text/csv;charset=utf-8;" });
            const link = document.createElement("a");
            link.href = URL.createObjectURL(blob);
            link.setAttribute("download", `form16_orders_${new Date().toISOString().split('T')[0]}.csv`);
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);

            hideLoading();
        }, 500);
    });

    // PDF Export
    document.getElementById("downloadPdfBtn").addEventListener("click", function() {
        if (filteredOrders.length === 0) {
            alert("No data to export.");
            return;
        }

        showLoading();

        setTimeout(() => {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF('l', 'mm', 'a4');

            // Add title
            doc.setFontSize(18);
            doc.setTextColor(102, 126, 234);
            doc.text('Form-16 Payment Orders Report', 20, 20);

            // Add date
            doc.setFontSize(10);
            doc.setTextColor(100, 100, 100);
            doc.text(`Generated on: ${new Date().toLocaleDateString()}`, 20, 30);

            const head = [["#", "Name", "Email", "Amount", "Gateway", "Status", "Service", "Phone"]];
            const body = filteredOrders.map((order, index) => [
                index + 1,
                order.first_name ?? order.name,
                order.form16_email ?? order.email ?? 'null',
                cleanAmount(order.net_amount),
                order.paymentGateway || 'N/A',
                getStatusBadgeText(String(order.paymentStatus)),
                order.orderFromName,
                order.phone
            ]);

            doc.autoTable({
                head,
                body,
                startY: 40,
                styles: {
                    fontSize: 8,
                    cellPadding: 3
                },
                headStyles: {
                    fillColor: [102, 126, 234],
                    textColor: 255,
                    fontStyle: 'bold'
                },
                alternateRowStyles: {
                    fillColor: [248, 249, 250]
                },
                margin: { left: 10, right: 10 }
            });

            doc.save(`form16_orders_${new Date().toISOString().split('T')[0]}.pdf`);
            hideLoading();
        }, 500);
    });

    // Initial load
    applyFilters();
});
</script>
@endsection
