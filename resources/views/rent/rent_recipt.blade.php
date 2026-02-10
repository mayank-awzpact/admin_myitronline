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
                                    <i class="bi bi-receipt fs-2"></i>
                                </div>
                                <div>
                                    <h2 class="fw-bold mb-1">Rent Receipts Management</h2>
                                    <p class="mb-0 opacity-75">Manage and track all rent receipt records</p>
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="bg-white text-black bg-opacity-20 rounded-lg p-3">
                                    <h3 class="fw-bold mb-0" id="totalReceipts">0</h3>
                                    <small class="opacity-75">Total Receipts</small>
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
                                <div class="col-lg-4 col-md-6">
                                    <label for="searchInput" class="form-label fw-semibold text-muted">
                                        <i class="bi bi-search me-1"></i>Search Records
                                    </label>
                                    <div class="input-group shadow-sm">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="bi bi-search text-muted"></i>
                                        </span>
                                        <input type="text" class="form-control border-start-0" id="searchInput"
                                            placeholder="Search by name, email, phone, receipt ID...">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <label for="tenantPANFilter" class="form-label fw-semibold text-muted">
                                        <i class="bi bi-credit-card me-1"></i>Tenant PAN
                                    </label>
                                    <input type="text" class="form-control shadow-sm" id="tenantPANFilter"
                                        placeholder="Enter Tenant PAN">
                                </div>
                                {{-- New Month Filter --}}
                                <div class="col-lg-3 col-md-6">
                                    <label for="monthFilter" class="form-label fw-semibold text-muted">
                                        <i class="bi bi-calendar-month me-1"></i>Filter by Month
                                    </label>
                                    <input type="month" class="form-control shadow-sm" id="monthFilter">
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <label class="form-label fw-semibold text-muted">Export Options</label>
                                    <div class="d-flex gap-2">
                                        <button id="downloadCsvBtn" class="btn btn-success shadow-sm flex-fill"
                                            title="Download CSV" data-bs-toggle="tooltip">
                                            <i class="bi bi-file-earmark-spreadsheet me-1"></i>CSV
                                        </button>
                                        <button id="downloadPdfBtn" class="btn btn-danger shadow-sm flex-fill"
                                            title="Download PDF" data-bs-toggle="tooltip">
                                            <i class="bi bi-file-earmark-pdf me-1"></i>PDF
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
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-outline-secondary" onclick="clearFilters()">
                                    <i class="bi bi-x-circle me-1"></i>Clear Filters
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
                                        <th class="py-3"><i class="bi bi-receipt me-1"></i>Receipt ID</th>
                                        <th class="py-3"><i class="bi bi-person me-1"></i>Tenant Name</th>
                                        <th class="py-3"><i class="bi bi-envelope me-1"></i>Email</th>
                                        <th class="py-3"><i class="bi bi-telephone me-1"></i>Phone</th>
                                        <th class="py-3"><i class="bi bi-credit-card me-1"></i>PAN</th>
                                        <th class="py-3"><i class="bi bi-house me-1"></i>Address</th>
                                        <th class="py-3"><i class="bi bi-currency-rupee me-1"></i>Rent</th>
                                        <th class="py-3"><i class="bi bi-gear me-1"></i>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="rentTableBody">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div class="text-muted mb-2 mb-md-0">
                        <span id="paginationInfo">Showing 0 to 0 of 0 results</span>
                    </div>
                    <nav aria-label="Rent receipts pagination">
                        <ul class="pagination mb-0" id="pagination">
                        </ul>
                    </nav>
                </div>
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

            let rents = @json($rent);
            let currentPage = 1;
            const rowsPerPage = 10;
            let filteredRents = [...rents];

            document.getElementById('totalReceipts').textContent = rents.length.toLocaleString();

            function showLoading() {
                document.getElementById('loadingOverlay').classList.remove('d-none');
            }

            function hideLoading() {
                document.getElementById('loadingOverlay').classList.add('d-none');
            }

            function filterTable() {
                showLoading();

                setTimeout(() => {
                    const searchQuery = document.getElementById("searchInput").value.toLowerCase().trim();
                    const tenantPAN = document.getElementById("tenantPANFilter").value.toLowerCase().trim();
                    const selectedMonth = document.getElementById("monthFilter").value; // Format: "YYYY-MM"

                    filteredRents = rents.filter(rent => {
                        const matchesSearch = !searchQuery ||
                            (rent.receiptId && rent.receiptId.toLowerCase().includes(
                            searchQuery)) ||
                            (rent.name && rent.name.toLowerCase().includes(searchQuery)) ||
                            (rent.email && rent.email.toLowerCase().includes(searchQuery)) ||
                            (rent.phoneNumber && rent.phoneNumber.includes(searchQuery)) ||
                            (rent.houseAddress && rent.houseAddress.toLowerCase().includes(
                                searchQuery));

                        const matchesTenantPAN = !tenantPAN ||
                            (rent.tenant_pan && rent.tenant_pan.toLowerCase().includes(tenantPAN));

                        const matchesMonth = !selectedMonth ||
                                             (rent.generateDate && rent.generateDate.startsWith(selectedMonth));

                        return matchesSearch && matchesTenantPAN && matchesMonth;
                    });

                    document.getElementById("filteredCount").innerHTML =
                        `<i class="bi bi-list-ul me-1"></i>Showing <strong>${filteredRents.length}</strong> results`;

                    currentPage = 1;
                    displayTable(currentPage);
                    hideLoading();
                }, 300);
            }

            function displayTable(page) {
                currentPage = page;
                const start = (page - 1) * rowsPerPage;
                const end = start + rowsPerPage;
                const paginatedRents = filteredRents.slice(start, end);
                const tbody = document.getElementById("rentTableBody");
                tbody.innerHTML = "";

                const showingFrom = filteredRents.length > 0 ? start + 1 : 0;
                const showingTo = Math.min(end, filteredRents.length);
                document.getElementById('paginationInfo').textContent =
                    `Showing ${showingFrom} to ${showingTo} of ${filteredRents.length} results`;

                if (paginatedRents.length === 0) {
                    tbody.innerHTML = `
                <tr>
                    <td colspan="9" class="text-center py-5">
                        <div class="text-muted">
                            <i class="bi bi-receipt display-1 d-block mb-3"></i>
                            <h5>No rent receipts found</h5>
                            <p>Try adjusting your filters to see more results.</p>
                        </div>
                    </td>
                </tr>
            `;
                    updatePagination();
                    return;
                }

                paginatedRents.forEach((rent, index) => {
                    const rowId = `collapseRow${start + index}`;
                    const monthlyRent = parseFloat(rent.monthlyRent || 0);

                    tbody.innerHTML += `
                <tr class="text-center">
                    <td class="fw-bold text-primary">${start + index + 1}</td>
                    <td><span class="receipt-id">${rent.receiptId}</span></td>
                    <td><span class="tenant-name">${rent.name}</span></td>
                    <td class="text-muted small">${rent.email}</td>
                    <td class="fw-medium">${rent.phoneNumber}</td>
                    <td><span class="pan-number" style="word-break: break-word; white-space: normal;">${rent.tenant_pan}</span></td>
                    <td class="text-start small" style="max-width: 200px;">
                        <div class="text-truncate" title="${rent.houseAddress}">
                            ${rent.houseAddress}
                        </div>
                    </td>
                    <td><span class="rent-amount">₹${monthlyRent.toLocaleString('en-IN')}</span></td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse"
                                data-bs-target="#${rowId}" title="View Details">
                            <i class="bi bi-eye"></i>
                        </button>
                    </td>
                </tr>
                <tr class="collapse collapse-row" id="${rowId}">
                    <td colspan="9">
                        <div class="card border-0 m-3">
                            <div class="card-body">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <h6 class="text-primary mb-3">
                                            <i class="bi bi-info-circle me-2"></i>Receipt Details
                                        </h6>
                                        <div class="row g-2">
                                            <div class="col-sm-5"><strong>Receipt ID:</strong></div>
                                            <div class="col-sm-7"><code>${rent.receiptId}</code></div>
                                            <div class="col-sm-5"><strong>Generate Date:</strong></div>
                                            <div class="col-sm-7">${new Date(rent.generateDate).toLocaleDateString()}</div>
                                            <div class="col-sm-5"><strong>Created On:</strong></div>
                                            <div class="col-sm-7">${new Date(rent.createdOn).toLocaleDateString()}</div>
                                            <div class="col-sm-5"><strong>Monthly Rent:</strong></div>
                                            <div class="col-sm-7 text-success fw-bold">₹${monthlyRent.toLocaleString('en-IN')}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="text-primary mb-3">
                                            <i class="bi bi-person-circle me-2"></i>Owner & Property Details
                                        </h6>
                                        <div class="row g-2">
                                            <div class="col-sm-5"><strong>Owner Name:</strong></div>
                                            <div class="col-sm-7">${rent.ownerName}</div>
                                            <div class="col-sm-5"><strong>Property Address:</strong></div>
                                            <div class="col-sm-7">${rent.houseAddress}</div>
                                            <div class="col-sm-5"><strong>Tenant PAN:</strong></div>
                                            <div class="col-sm-7"><code>${rent.tenant_pan}</code></div>
                                            <div class="col-sm-5"><strong>Contact:</strong></div>
                                            <div class="col-sm-7">
                                                <a href="tel:${rent.phoneNumber}" class="text-decoration-none">
                                                    ${rent.phoneNumber}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-3">
                                <div class="d-flex justify-content-end gap-2">
                                    <button class="btn btn-sm btn-outline-primary" onclick="viewReceipt('${rent.receiptId}')">
                                        <i class="bi bi-eye me-1"></i>View Receipt
                                    </button>
                                    <button class="btn btn-sm btn-outline-success" onclick="downloadReceipt('${rent.receiptId}')">
                                        <i class="bi bi-download me-1"></i>Download
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
                const totalPages = Math.ceil(filteredRents.length / rowsPerPage);
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

                paginationHTML += `
            <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                <a class="page-link" href="#" onclick="changePage(${currentPage - 1})" ${currentPage === 1 ? 'tabindex="-1"' : ''}>
                    Previous
                </a>
            </li>
        `;

                for (let i = startPage; i <= endPage; i++) {
                    paginationHTML += `
                <li class="page-item ${i === currentPage ? 'active' : ''}">
                    <a class="page-link" href="#" onclick="changePage(${i})">${i}</a>
                </li>
            `;
                }

                paginationHTML += `
            <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                <a class="page-link" href="#" onclick="changePage(${currentPage + 1})" ${currentPage === totalPages ? 'tabindex="-1"' : ''}>
                    Next
                </a>
            </li>
        `;

                document.getElementById("pagination").innerHTML = paginationHTML;
            }

            window.changePage = function(page) {
                const totalPages = Math.ceil(filteredRents.length / rowsPerPage);
                if (page < 1 || page > totalPages) return;

                currentPage = page;
                displayTable(page);

                document.querySelector('.table-responsive').scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            };

            window.refreshData = function() {
                showLoading();
                setTimeout(() => {
                    filteredRents = [...rents];
                    displayTable(1);
                    hideLoading();
                }, 500);
            };

            window.clearFilters = function() {
                document.getElementById("searchInput").value = '';
                document.getElementById("tenantPANFilter").value = '';
                document.getElementById("monthFilter").value = '';
                filterTable();
            };

            window.viewReceipt = function(receiptId) {
                alert(`View receipt: ${receiptId}`);
            };

            window.downloadReceipt = function(receiptId) {
                alert(`Download receipt: ${receiptId}`);

            };

            document.getElementById("searchInput").addEventListener("input", filterTable);
            document.getElementById("tenantPANFilter").addEventListener("input", filterTable);
            document.getElementById("monthFilter").addEventListener("input", filterTable);

            document.getElementById("downloadCsvBtn").addEventListener("click", () => {
                if (filteredRents.length === 0) {
                    alert("No data to export.");
                    return;
                }

                showLoading();

                setTimeout(() => {
                    const csvRows = [];
                    const headers = ["#", "Receipt ID", "Name", "Email", "Phone", "Tenant PAN",
                        "House Address", "Monthly Rent", "Owner Name", "Generate Date"
                    ];
                    csvRows.push(headers.join(","));

                    filteredRents.forEach((rent, i) => {
                        const row = [
                            i + 1,
                            `"${rent.receiptId}"`,
                            `"${rent.name}"`,
                            `"${rent.email}"`,
                            `"${rent.phoneNumber}"`,
                            `"${rent.tenant_pan}"`,
                            `"${rent.houseAddress}"`,
                            `"${rent.monthlyRent}"`,
                            `"${rent.ownerName}"`,
                            `"${rent.generateDate}"`
                        ];
                        csvRows.push(row.join(","));
                    });

                    const blob = new Blob([csvRows.join("\n")], {
                        type: "text/csv;charset=utf-8;"
                    });
                    const link = document.createElement("a");
                    link.href = URL.createObjectURL(blob);
                    link.setAttribute("download",
                        `rent_receipts_${new Date().toISOString().split('T')[0]}.csv`);
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);

                    hideLoading();
                }, 500);
            });

            document.getElementById("downloadPdfBtn").addEventListener("click", () => {
                if (filteredRents.length === 0) {
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
                    doc.text('Rent Receipts Report', 20, 20);

                    doc.setFontSize(10);
                    doc.setTextColor(100, 100, 100);
                    doc.text(`Generated on: ${new Date().toLocaleDateString()}`, 20, 30);

                    const headers = [
                        ["#", "Receipt ID", "Name", "Email", "Phone", "PAN", "Monthly Rent",
                            "Owner"
                        ]
                    ];
                    const body = filteredRents.map((rent, i) => [
                        i + 1,
                        rent.receiptId,
                        rent.name,
                        rent.email,
                        rent.phoneNumber,
                        rent.tenant_pan,
                        `₹${parseFloat(rent.monthlyRent || 0).toLocaleString('en-IN')}`,
                        rent.ownerName
                    ]);

                    doc.autoTable({
                        head: headers,
                        body: body,
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

                    doc.save(`rent_receipts_${new Date().toISOString().split('T')[0]}.pdf`);
                    hideLoading();
                }, 500);
            });

            displayTable(1);
        });
    </script>
@endsection
