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
                                    <i class="bi bi-flag-fill fs-2"></i>
                                </div>
                                <div>
                                    <h2 class="fw-bold mb-1">UTM Campaign Analytics</h2>
                                    <p class="mb-0 opacity-75">Track and analyze marketing campaign performance</p>
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="bg-white text-black bg-opacity-20 rounded-lg p-3">
                                    <h3 class="fw-bold mb-0" id="totalCampaigns">0</h3>
                                    <small class="opacity-75">Total Campaigns</small>
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
                                <i class="bi bi-funnel me-2 text-primary"></i>Campaign Filters
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
                                <div class="col-lg-3 col-md-4 col-sm-6">
                                    <label for="utmSourceFilter" class="form-label fw-semibold text-muted">
                                        <i class="bi bi-diagram-3 me-1"></i>UTM Source
                                    </label>
                                    <div class="input-group shadow-sm">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="bi bi-diagram-3 text-muted"></i>
                                        </span>
                                        <input type="text" class="form-control border-start-0" id="utmSourceFilter"
                                            placeholder="Enter source (e.g., google, facebook)">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6">
                                    <label for="utmMediumFilter" class="form-label fw-semibold text-muted">
                                        <i class="bi bi-broadcast me-1"></i>UTM Medium
                                    </label>
                                    <div class="input-group shadow-sm">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="bi bi-broadcast text-muted"></i>
                                        </span>
                                        <input type="text" class="form-control border-start-0" id="utmMediumFilter"
                                            placeholder="Enter medium (e.g., cpc, email)">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-6">
                                    <label for="searchInput" class="form-label fw-semibold text-muted">
                                        <i class="bi bi-search me-1"></i>Search Campaigns
                                    </label>
                                    <div class="input-group shadow-sm">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="bi bi-search text-muted"></i>
                                        </span>
                                        <input type="text" class="form-control border-start-0" id="searchInput"
                                            placeholder="Search campaign, term, content...">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6 col-sm-6" style="display: none">
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

        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3 d-inline-flex mb-3">
                            <i class="bi bi-diagram-3 fs-4 text-primary"></i>
                        </div>
                        <h5 class="fw-bold mb-1" id="uniqueSources">0</h5>
                        <small class="text-muted">Unique Sources</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="bg-success bg-opacity-10 rounded-circle p-3 d-inline-flex mb-3">
                            <i class="bi bi-broadcast fs-4 text-success"></i>
                        </div>
                        <h5 class="fw-bold mb-1" id="uniqueMediums">0</h5>
                        <small class="text-muted">Unique Mediums</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3 d-inline-flex mb-3">
                            <i class="bi bi-flag fs-4 text-warning"></i>
                        </div>
                        <h5 class="fw-bold mb-1" id="uniqueCampaigns">0</h5>
                        <small class="text-muted">Unique Campaigns</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="bg-info bg-opacity-10 rounded-circle p-3 d-inline-flex mb-3">
                            <i class="bi bi-calendar-event fs-4 text-info"></i>
                        </div>
                        <h5 class="fw-bold mb-1" id="recentCampaigns">0</h5>
                        <small class="text-muted">This Month</small>
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
                                <button class="btn btn-sm btn-outline-primary" onclick="clearFilters()">
                                    <i class="bi bi-arrow-clockwise me-1"></i>Clear Filters
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
                                        <th class="py-3"><i class="bi bi-diagram-3 me-1"></i>Source</th>
                                        <th class="py-3"><i class="bi bi-broadcast me-1"></i>Medium</th>
                                        <th class="py-3"><i class="bi bi-flag me-1"></i>Campaign</th>
                                        <th class="py-3"><i class="bi bi-tag me-1"></i>Term</th>
                                        <th class="py-3"><i class="bi bi-file-text me-1"></i>Content</th>
                                        <th class="py-3"><i class="bi bi-calendar me-1"></i>Created At</th>
                                    </tr>
                                </thead>
                                <tbody id="utmTable">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <nav aria-label="UTM Campaign pagination">
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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            let utms = @json($utm);
            let currentPage = 1;
            const rowsPerPage = 10;
            let filteredUtms = [...utms];

            updateStatistics();

            function updateStatistics() {
                document.getElementById('totalCampaigns').textContent = utms.length.toLocaleString();

                const uniqueSources = [...new Set(utms.map(item => item.utm_source).filter(Boolean))];
                const uniqueMediums = [...new Set(utms.map(item => item.utm_medium).filter(Boolean))];
                const uniqueCampaigns = [...new Set(utms.map(item => item.utm_campaign).filter(Boolean))];

                document.getElementById('uniqueSources').textContent = uniqueSources.length;
                document.getElementById('uniqueMediums').textContent = uniqueMediums.length;
                document.getElementById('uniqueCampaigns').textContent = uniqueCampaigns.length;

                const thisMonth = new Date().getMonth();
                const thisYear = new Date().getFullYear();
                const recentCampaigns = utms.filter(item => {
                    const createdDate = new Date(item.created_at);
                    return createdDate.getMonth() === thisMonth && createdDate.getFullYear() === thisYear;
                });
                document.getElementById('recentCampaigns').textContent = recentCampaigns.length;
            }

            function showLoading() {
                document.getElementById('loadingOverlay').classList.remove('d-none');
            }

            function hideLoading() {
                document.getElementById('loadingOverlay').classList.add('d-none');
            }

            function getSourceBadge(source) {
                if (!source) return '<span class="badge bg-light text-dark">N/A</span>';

                const sourceColors = {
                    'google': 'bg-danger',
                    'facebook': 'bg-primary',
                    'twitter': 'bg-info',
                    'linkedin': 'bg-primary',
                    'instagram': 'bg-warning',
                    'youtube': 'bg-danger',
                    'email': 'bg-success',
                    'direct': 'bg-dark'
                };

                const colorClass = sourceColors[source.toLowerCase()] || 'bg-secondary';
                return `<span class="badge ${colorClass} utm-badge">${source}</span>`;
            }

            function getMediumBadge(medium) {
                if (!medium) return '<span class="badge bg-light text-dark">N/A</span>';

                const mediumColors = {
                    'cpc': 'bg-warning',
                    'organic': 'bg-success',
                    'email': 'bg-info',
                    'social': 'bg-primary',
                    'referral': 'bg-secondary',
                    'direct': 'bg-dark'
                };

                const colorClass = mediumColors[medium.toLowerCase()] || 'bg-secondary';
                return `<span class="badge ${colorClass} utm-badge">${medium}</span>`;
            }

            function formatDate(dateString) {
                const date = new Date(dateString);
                return date.toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });
            }

            function filterTable() {
                showLoading();

                setTimeout(() => {
                    const searchQuery = document.getElementById("searchInput").value.toLowerCase().trim();
                    const utmSource = document.getElementById("utmSourceFilter").value.toLowerCase().trim();
                    const utmMedium = document.getElementById("utmMediumFilter").value.toLowerCase().trim();

                    filteredUtms = utms.filter(item => {
                        const matchesSearch = !searchQuery ||
                            (item.utm_campaign && item.utm_campaign.toLowerCase().includes(
                                searchQuery)) ||
                            (item.utm_term && item.utm_term.toLowerCase().includes(searchQuery)) ||
                            (item.utm_content && item.utm_content.toLowerCase().includes(
                                searchQuery));

                        const matchesSource = !utmSource ||
                            (item.utm_source && item.utm_source.toLowerCase().includes(utmSource));

                        const matchesMedium = !utmMedium ||
                            (item.utm_medium && item.utm_medium.toLowerCase().includes(utmMedium));

                        return matchesSearch && matchesSource && matchesMedium;
                    });

                    document.getElementById("filteredCount").innerHTML =
                        `<i class="bi bi-list-ul me-1"></i>Showing <strong>${filteredUtms.length}</strong> results`;

                    currentPage = 1;
                    displayTable(currentPage);
                    hideLoading();
                }, 300);
            }

            function displayTable(page) {
                currentPage = page;
                const start = (page - 1) * rowsPerPage;
                const end = start + rowsPerPage;
                const paginated = filteredUtms.slice(start, end);
                const tbody = document.getElementById("utmTable");

                if (paginated.length === 0) {
                    tbody.innerHTML = `
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <div class="text-muted">
                            <i class="bi bi-flag display-1 d-block mb-3"></i>
                            <h5>No UTM campaigns found</h5>
                            <p>Try adjusting your filters to see more results.</p>
                        </div>
                    </td>
                </tr>
            `;
                    return;
                }

                let tableBody = "";
                paginated.forEach((item, index) => {
                    tableBody += `
                <tr class="text-center">
                    <td class="fw-bold text-primary">${start + index + 1}</td>
                    <td>${getSourceBadge(item.utm_source)}</td>
                    <td>${getMediumBadge(item.utm_medium)}</td>
                    <td class="fw-semibold">${item.utm_campaign || '<span class="text-muted">N/A</span>'}</td>
                    <td>${item.utm_term ? `<code class="bg-light text-dark px-2 py-1 rounded">${item.utm_term}</code>` : '<span class="text-muted">N/A</span>'}</td>
                    <td>${item.utm_content ? `<small class="text-muted">${item.utm_content}</small>` : '<span class="text-muted">N/A</span>'}</td>
                    <td class="text-muted small">${formatDate(item.created_at)}</td>
                </tr>
            `;
                });

                tbody.innerHTML = tableBody;
                updatePagination();
            }

            function updatePagination() {
                const totalPages = Math.ceil(filteredUtms.length / rowsPerPage);
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
                const totalPages = Math.ceil(filteredUtms.length / rowsPerPage);
                if (page < 1 || page > totalPages) return;
                currentPage = page;
                displayTable(page);

                document.querySelector('.table-responsive').scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            };

            window.clearFilters = function() {
                document.getElementById("searchInput").value = "";
                document.getElementById("utmSourceFilter").value = "";
                document.getElementById("utmMediumFilter").value = "";
                filterTable();
            };


            document.getElementById("searchInput").addEventListener("input", filterTable);
            document.getElementById("utmSourceFilter").addEventListener("input", filterTable);
            document.getElementById("utmMediumFilter").addEventListener("input", filterTable);


            document.getElementById("downloadCsvBtn").addEventListener("click", () => {
                if (filteredUtms.length === 0) {
                    alert("No data to export.");
                    return;
                }

                showLoading();

                setTimeout(() => {
                    const csvRows = [];
                    const headers = ["#", "Source", "Medium", "Campaign", "Term", "Content",
                        "Created At"
                    ];
                    csvRows.push(headers.join(","));

                    filteredUtms.forEach((item, i) => {
                        const row = [
                            i + 1,
                            `"${item.utm_source || ''}"`,
                            `"${item.utm_medium || ''}"`,
                            `"${item.utm_campaign || ''}"`,
                            `"${item.utm_term || ''}"`,
                            `"${item.utm_content || ''}"`,
                            `"${item.created_at}"`
                        ];
                        csvRows.push(row.join(","));
                    });

                    const blob = new Blob([csvRows.join("\n")], {
                        type: "text/csv;charset=utf-8;"
                    });
                    const link = document.createElement("a");
                    link.href = URL.createObjectURL(blob);
                    link.setAttribute("download",
                        `utm_campaigns_${new Date().toISOString().split('T')[0]}.csv`);
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);

                    hideLoading();
                }, 500);
            });

            document.getElementById("downloadPdfBtn").addEventListener("click", function() {
                if (filteredUtms.length === 0) {
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
                    doc.text('UTM Campaign Analytics Report', 20, 20);

                    doc.setFontSize(10);
                    doc.setTextColor(100, 100, 100);
                    doc.text(`Generated on: ${new Date().toLocaleDateString()}`, 20, 30);

                    const head = [
                        ["#", "Source", "Medium", "Campaign", "Term", "Content", "Created At"]
                    ];
                    const body = filteredUtms.map((item, index) => [
                        index + 1,
                        item.utm_source || '',
                        item.utm_medium || '',
                        item.utm_campaign || '',
                        item.utm_term || '',
                        item.utm_content || '',
                        formatDate(item.created_at)
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

                    doc.save(`utm_campaigns_${new Date().toISOString().split('T')[0]}.pdf`);
                    hideLoading();
                }, 500);
            });

            displayTable(1);
        });
    </script>
@endsection
