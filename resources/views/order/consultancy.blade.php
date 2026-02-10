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
                                    <i class="bi bi-wallet2 fs-2"></i>
                                </div>
                                <div>
                                    <h2 class="fw-bold mb-1">Consultancy Payment Management</h2>
                                    <p class="mb-0 opacity-75">Track and manage all payment transactions</p>
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="bg-white text-black bg-opacity-20 rounded-lg p-3">
                                    <h3 class="fw-bold mb-0" id="totalPayments">0</h3>
                                    <small class="opacity-75">Total Payments</small>
                                </div>
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
                            <div class="row g-3 align-items-end">
                                <div class="col-lg-2 col-md-4 col-sm-6">
                                    <label for="statusFilter" class="form-label fw-semibold text-muted">
                                        <i class="bi bi-check-circle me-1"></i>Status
                                    </label>
                                    <select class="form-select shadow-sm" id="statusFilter">
                                        <option value="">All Status</option>
                                        <option value="1">Success</option>
                                        <option value="2">Pending</option>
                                        <option value="0">Failed</option>
                                    </select>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-6">
                                    <label for="gatewayFilter" class="form-label fw-semibold text-muted">
                                        <i class="bi bi-credit-card me-1"></i>Gateway
                                    </label>
                                    <select class="form-select shadow-sm" id="gatewayFilter">
                                        <option value="">All Gateways</option>
                                        <option value="razorpay">Razorpay</option>
                                        <option value="Paytm">Paytm</option>
                                        <option value="ccAvanue">CCAvenue</option>
                                    </select>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-6">
                                    <label for="searchurl" class="form-label fw-semibold text-muted">
                                        <i class="bi bi-globe me-1"></i>Domain
                                    </label>
                                    <select class="form-select shadow-sm" id="searchurl">
                                        <option value="">All Domains</option>
                                        <option value="myitronline.com">myitronline.com</option>
                                        <option value="eitrfiling.com">eitfiling.com</option>
                                        <option value="clarityefiling.com">clarityefiling.in</option>
                                    </select>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-6">
                                    <label for="monthYearFilter" class="form-label fw-semibold text-muted">
                                        <i class="bi bi-calendar-month me-1"></i>Date
                                    </label>
                                    <input type="month" class="form-control shadow-sm" id="monthYearFilter">
                                </div>
                                <div class="col-lg col-md-4 col-sm-6">
                                    <label for="searchInput" class="form-label fw-semibold text-muted">
                                        <i class="bi bi-search me-1"></i>Search
                                    </label>
                                    <input type="text" class="form-control shadow-sm" id="searchInput"
                                        placeholder="Search name, email, mobile, order ID...">
                                </div>
                                <div class="col-lg-auto col-md-4 col-sm-12">
                                     <label class="form-label fw-semibold text-muted d-block d-md-none">Actions</label>
                                    <div class="d-flex gap-2">
                                        <button id="clearFiltersBtn" class="btn btn-outline-secondary shadow-sm"
                                            title="Clear Filters" data-bs-toggle="tooltip">
                                            <i class="bi bi-arrow-clockwise"></i>
                                        </button>
                                        <button id="downloadCsvBtn" class="btn btn-success shadow-sm"
                                            title="Download CSV" data-bs-toggle="tooltip">
                                            <i class="bi bi-file-earmark-spreadsheet"></i>
                                        </button>
                                        <button id="downloadPdfBtn" class="btn btn-danger shadow-sm"
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

        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-dark">
                                    <tr class="text-center">
                                        <th class="py-3">#</th>
                                        <th class="py-3"><i class="bi bi-calendar3 me-1"></i>Order Date</th>
                                        <th class="py-3"><i class="bi bi-person me-1"></i>Name</th>
                                        <th class="py-3"><i class="bi bi-currency-rupee me-1"></i>Amount</th>
                                        <th class="py-3"><i class="bi bi-receipt me-1"></i>GST</th>
                                        <th class="py-3"><i class="bi bi-calculator me-1"></i>Total</th>
                                        <th class="py-3"><i class="bi bi-credit-card me-1"></i>Gateway</th>
                                        <th class="py-3"><i class="bi bi-check-circle me-1"></i>Status</th>
                                        <th class="py-3"><i class="bi bi-globe me-1"></i>Domain</th>
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

        <div class="row mt-4">
            <div class="col-12">
                <nav aria-label="Payment pagination">
                    <ul class="pagination pagination-lg justify-content-center shadow-sm" id="pagination">
                    </ul>
                </nav>
            </div>
        </div>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            let orders = @json($orders);
            let currentPage = 1;
            const rowsPerPage = 10;
            let filteredOrders = [...orders];

            document.getElementById('totalPayments').textContent = orders.length.toLocaleString();

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

            const extractDomainFromUrl = url => {
                if (!url) return "";
                try {
                    return new URL(url).hostname.replace("www.", "");
                } catch {
                    return "";
                }
            };

            const getStatusBadge = status => {
                switch (status) {
                    case "0":
                        return '<span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2"><i class="bi bi-x-circle-fill me-1"></i>Failed</span>';
                    case "1":
                        return '<span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2"><i class="bi bi-check-circle-fill me-1"></i>Success</span>';
                    case "2":
                        return '<span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-2"><i class="bi bi-clock-history me-1"></i>Pending</span>';
                    default:
                        return '<span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-3 py-2"><i class="bi bi-question-circle-fill me-1"></i>Unknown</span>';
                }
            };

            const getStatusBadgeText = status => {
                switch (status) {
                    case "0":
                        return "Failed";
                    case "1":
                        return "Success";
                    case "2":
                        return "Pending";
                    default:
                        return "Unknown";
                }
            };

            const getGatewayBadge = gateway => {
                if (!gateway) return '<span class="badge bg-light text-dark">N/A</span>';
                return `<span class="badge bg-info-subtle text-info border border-info-subtle px-3 py-2">${gateway}</span>`;
            };

            function updateStatusCounts() {
                const successCount = filteredOrders.filter(order => String(order.paymentStatus) === "1").length;
                const pendingCount = filteredOrders.filter(order => String(order.paymentStatus) === "2").length;
                const failedCount = filteredOrders.filter(order => String(order.paymentStatus) === "0").length;

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

            function filterTable() {
                showLoading();

                setTimeout(() => {
                    const query = document.getElementById("searchInput").value.toLowerCase();
                    const status = document.getElementById("statusFilter").value;
                    const selectedDomain = document.getElementById("searchurl").value.toLowerCase();
                    const selectedGateway = document.getElementById("gatewayFilter").value.toLowerCase();
                    const selectedMonthYear = document.getElementById("monthYearFilter").value;

                    filteredOrders = orders.filter(order => {
                        const domainFromUrl = extractDomainFromUrl(order.serviceUrl);

                        const matchesDomain = !selectedDomain || domainFromUrl === selectedDomain;
                        const matchesGateway = !selectedGateway || (order.paymentGateway && order
                            .paymentGateway.toLowerCase() === selectedGateway);
                        const matchesQuery =
                            (order.orderId && order.orderId.toLowerCase().includes(query)) ||
                            (order.name && order.name.toLowerCase().includes(query)) ||
                            (order.email && order.email.toLowerCase().includes(query)) ||
                            (order.mobile && order.mobile.includes(query)) ||
                            (order.amount && order.amount.toString().includes(query));
                        const matchesStatus = !status || String(order.paymentStatus) === status;

                        let matchesDate = true;
                        if (selectedMonthYear) {
                            if (order.createdOn && typeof order.createdOn === 'string') {
                                const parts = order.createdOn.split('-');
                                if (parts.length === 3) {
                                    const month = parts[1];
                                    const year = parts[2];
                                    const orderMonthYear = `${year}-${month}`;
                                    matchesDate = orderMonthYear === selectedMonthYear;
                                } else {
                                    matchesDate = false;
                                }
                            } else {
                                matchesDate = false;
                            }
                        }

                        return matchesQuery && matchesStatus && matchesDomain && matchesGateway && matchesDate;
                    });

                    document.getElementById("filteredCount").innerHTML =
                        `<i class="bi bi-list-ul me-1"></i>Showing <strong>${filteredOrders.length}</strong> results`;

                    updateStatusCounts();
                    currentPage = 1;
                    displayTable(currentPage);
                    hideLoading();
                }, 300);
            }

            function displayTable(page) {
                currentPage = page;
                const start = (page - 1) * rowsPerPage;
                const end = start + rowsPerPage;
                const paginatedOrders = filteredOrders.slice(start, end);
                const tbody = document.getElementById("ordersTableBody");
                tbody.innerHTML = "";

                if (paginatedOrders.length === 0) {
                    tbody.innerHTML = `
                <tr>
                    <td colspan="10" class="text-center py-5">
                        <div class="text-muted">
                            <i class="bi bi-inbox display-1 d-block mb-3"></i>
                            <h5>No payments found</h5>
                            <p>Try adjusting your filters to see more results.</p>
                        </div>
                    </td>
                </tr>
            `;
                    return;
                }

                paginatedOrders.forEach((order, index) => {
                    const rowId = `collapseRow${index}`;
                    tbody.innerHTML += `
                <tr class="text-center">
                    <td class="fw-bold text-primary">${start + index + 1}</td>
                    <td class="text-muted small">${order.createdOn}</td>
                    <td class="fw-semibold">${order.name}</td>
                    <td class="fw-bold text-success">₹${cleanAmount(order.amount)}</td>
                    <td class="text-warning">₹${cleanAmount(order.tax_amount)}</td>
                    <td class="fw-bold text-primary">₹${cleanAmount(order.net_amount)}</td>
                    <td>${getGatewayBadge(order.paymentGateway)}</td>
                    <td>${getStatusBadge(String(order.paymentStatus))}</td>
                    <td><span class="badge bg-light text-dark border">${extractDomainFromUrl(order.serviceUrl)}</span></td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary shadow-sm" data-bs-toggle="collapse"
                                data-bs-target="#${rowId}" title="View Details">
                            <i class="bi bi-eye"></i>
                        </button>
                    </td>
                </tr>
                <tr class="collapse collapse-row" id="${rowId}">
                    <td colspan="10">
                        <div class="card border-0 m-3">
                            <div class="card-body">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <h6 class="text-primary mb-3"><i class="bi bi-info-circle me-2"></i>Order Details</h6>
                                        <div class="row g-2">
                                            <div class="col-sm-4"><strong>Domain:</strong></div>
                                            <div class="col-sm-8">${extractDomainFromUrl(order.serviceUrl)}</div>
                                            <div class="col-sm-4"><strong>Service:</strong></div>
                                            <div class="col-sm-8">${order.orderFromName}</div>
                                            <div class="col-sm-4"><strong>Order ID:</strong></div>
                                            <div class="col-sm-8"><code>${order.orderId}</code></div>
                                            <div class="col-sm-4"><strong>Order Date:</strong></div>
                                            <div class="col-sm-8">${order.createdOn}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="text-primary mb-3"><i class="bi bi-person-circle me-2"></i>Customer Details</h6>
                                        <div class="row g-2">
                                            <div class="col-sm-4"><strong>Email:</strong></div>
                                            <div class="col-sm-8"><a href="mailto:${order.email}" class="text-decoration-none">${order.email}</a></div>
                                            <div class="col-sm-4"><strong>Mobile:</strong></div>
                                            <div class="col-sm-8"><a href="tel:${order.mobile}" class="text-decoration-none">${order.mobile}</a></div>
                                            <div class="col-sm-4"><strong>PAN:</strong></div>
                                            <div class="col-sm-8"><code style="word-break: break-word; white-space: normal;">${order.pan}</code></div>
                                            <div class="col-sm-4"><strong>Invoice:</strong></div>
                                            <div class="col-sm-8">
                                                <a href="${order.invoicePath}" class="btn btn-sm btn-outline-success" target="_blank" download>
                                                    <i class="bi bi-download me-1"></i>Download
                                                </a>
                                            </div>
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
                const maxVisiblePages = 5;
                let startPage = Math.max(currentPage - Math.floor(maxVisiblePages / 2), 1);
                let endPage = Math.min(startPage + maxVisiblePages - 1, totalPages);

                if (endPage > totalPages) endPage = totalPages;

                let paginationHTML = "";

                paginationHTML += `
            <li class="page-item ${currentPage === 1 ? "disabled" : ""}">
                <a class="page-link" href="#" onclick="changePage(${currentPage - 1})">
                    <i class="bi bi-chevron-left"></i> Previous
                </a>
            </li>
        `;

                for (let i = startPage; i <= endPage; i++) {
                    paginationHTML += `
                <li class="page-item ${i === currentPage ? "active" : ""}">
                    <a class="page-link" href="#" onclick="changePage(${i})">${i}</a>
                </li>
            `;
                }

                paginationHTML += `
            <li class="page-item ${currentPage === totalPages ? "disabled" : ""}">
                <a class="page-link" href="#" onclick="changePage(${currentPage + 1})">
                    Next <i class="bi bi-chevron-right"></i>
                </a>
            </li>
        `;

                document.getElementById("pagination").innerHTML = paginationHTML;
            }

            window.changePage = function(page) {
                const totalPages = Math.ceil(filteredOrders.length / rowsPerPage);
                if (page < 1 || page > totalPages) return;
                currentPage = page;
                displayTable(page);


                document.querySelector('.table-responsive').scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            };

            // Event listener for the new "Clear Filters" button
            document.getElementById("clearFiltersBtn").addEventListener("click", () => {
                document.getElementById("searchInput").value = "";
                document.getElementById("statusFilter").value = "";
                document.getElementById("searchurl").value = "";
                document.getElementById("gatewayFilter").value = "";
                document.getElementById("monthYearFilter").value = "";
                filterTable();
            });

            document.querySelectorAll("#searchInput, #statusFilter, #searchurl, #gatewayFilter, #monthYearFilter")
                .forEach(input => {
                    input.addEventListener("input", filterTable);
                    input.addEventListener("change", filterTable);
                });

            document.getElementById("downloadCsvBtn").addEventListener("click", () => {
                if (filteredOrders.length === 0) {
                    alert("No data to export.");
                    return;
                }

                showLoading();

                setTimeout(() => {
                    const csvRows = [];
                    const headers = ["#", "Order Date", "Name", "Amount", "GST 18%", "Total Amount",
                        "Payment Gateway", "Status", "Domain", "Mobile"
                    ];
                    csvRows.push(headers.join(","));

                    filteredOrders.forEach((order, i) => {
                        const row = [
                            i + 1,
                            `"${order.createdOn}"`,
                            `"${order.name}"`,
                            `"${cleanAmount(order.amount)}"`,
                            `"${cleanAmount(order.tax_amount)}"`,
                            `"${cleanAmount(order.net_amount)}"`,
                            `"${order.paymentGateway || ''}"`,
                            `"${getStatusBadgeText(String(order.paymentStatus))}"`,
                            `"${extractDomainFromUrl(order.serviceUrl)}"`,
                            `"${order.mobile}"`
                        ];
                        csvRows.push(row.join(","));
                    });

                    const blob = new Blob([csvRows.join("\n")], {
                        type: "text/csv;charset=utf-8;"
                    });
                    const link = document.createElement("a");
                    link.href = URL.createObjectURL(blob);
                    link.setAttribute("download",
                        `consultancy_payments_${new Date().toISOString().split('T')[0]}.csv`);
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);

                    hideLoading();
                }, 500);
            });

            document.getElementById("downloadPdfBtn").addEventListener("click", function() {
                if (filteredOrders.length === 0) {
                    alert("No data to export.");
                    return;
                }

                showLoading();

                setTimeout(() => {
                    const {
                        jsPDF
                    } = window.jspdf;
                    const doc = new jsPDF('l', 'mm', 'a4');

                    doc.setFontSize(18);
                    doc.setTextColor(102, 126, 234);
                    doc.text('Consultancy Payment Report', 20, 20);

                    doc.setFontSize(10);
                    doc.setTextColor(100, 100, 100);
                    doc.text(`Generated on: ${new Date().toLocaleDateString()}`, 20, 30);

                    const head = [
                        ["#", "Order Date", "Name", "Amount", "GST 18%", "Total", "Gateway", "Status",
                            "Domain", "Mobile"
                        ]
                    ];
                    const body = filteredOrders.map((order, index) => [
                        index + 1,
                        order.createdOn,
                        order.name,
                        cleanAmount(order.amount),
                        cleanAmount(order.tax_amount),
                        cleanAmount(order.net_amount),
                        order.paymentGateway || '',
                        getStatusBadgeText(String(order.paymentStatus)),
                        extractDomainFromUrl(order.serviceUrl),
                        order.mobile
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
                        margin: {
                            left: 10,
                            right: 10
                        }
                    });

                    doc.save(`consultancy_payments_${new Date().toISOString().split('T')[0]}.pdf`);
                    hideLoading();
                }, 500);
            });

            filterTable();
        });
    </script>
@endsection
