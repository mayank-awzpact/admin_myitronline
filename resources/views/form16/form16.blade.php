@extends('backend.app')

@section('content')
<div class="container mt-3">
    <h3><i class="bi bi-database-check"></i> Form 16 Records</h3>

    <div class="row mb-3">
        <div class="col-md-4">
            <input type="text" id="searchInput" class="form-control form-control-sm" placeholder="Search Assessment Year, Income, PAN, etc.">
        </div>
        <div class="col-md-8 text-end">
            <span id="recordCount" class="small"></span>
        </div>
    </div>

    <table class="table table-bordered table-striped table-sm">
        <thead>
            <tr>
                <th>#</th>
                <th>Taxable Income</th>
                <th>DTI</th>
                <th>Surcharge</th>
                <th>Health Cess</th>
                <th>Assessment Year</th>
                <th>Employee PAN</th>
                <th>Employer Details</th>
                <th>Employee Details</th>
                <th>Deductor PAN</th>
                <th>Deductor TAN</th>
                {{-- <th>PDF</th> --}}
            </tr>
        </thead>
        <tbody id="recordsTable"></tbody>
    </table>

    <nav>
        <ul class="pagination pagination-sm justify-content-center" id="pagination"></ul>
    </nav>
</div>

<script>
    const basePdfUrl = "{{ asset('storage') }}"; 
    const allData = @json($form16);
    let filteredData = [...allData];
    let currentPage = 1;
    const rowsPerPage = 10;


    function renderTable(page = 1) {
        currentPage = page;
        const start = (page - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        const currentRecords = filteredData.slice(start, end);

        let html = '';
currentRecords.forEach((record, index) => {
    const json = record.form16json;
    if (!json || Object.keys(json).length === 0) return;

    // Ensure the correct file path is generated
    const pdfLink = `{{ asset('storage') }}/${encodeURIComponent(record.pdf_path)}`;

    html += `
        <tr>
            <td>${start + index + 1}</td>
            <td>${json.totalTaxableIncomeMatch ?? '-'}</td>
            <td>${json.totalDTIMatch ?? '-'}</td>
            <td>${json.surchargeMatch ?? '-'}</td>
            <td>${json.healthCessMatch ?? '-'}</td>
            <td>${json.assessmentYear ?? '-'}</td>
            <td>${json.employeePAN ?? '-'}</td>
            <td>${json.employerDetails ?? '-'}</td>
            <td>${json.employeeDetails ?? '-'}</td>
            <td>${json.deductorPAN ?? '-'}</td>
            <td>${json.deductorTAN ?? '-'}</td>
           
        </tr>
    `;
});


        document.getElementById('recordsTable').innerHTML = html;
        document.getElementById('recordCount').textContent = `Showing ${filteredData.length} result(s)`;
        renderPagination();
    }


    function renderPagination() {
        const totalPages = Math.ceil(filteredData.length / rowsPerPage);
        let html = '';

        if (totalPages <= 1) {
            document.getElementById('pagination').innerHTML = '';
            return;
        }

        html += `
            <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                <a class="page-link" href="#" onclick="goToPage(${currentPage - 1})">Previous</a>
            </li>
        `;

        for (let i = 1; i <= totalPages; i++) {
            html += `
                <li class="page-item ${i === currentPage ? 'active' : ''}">
                    <a class="page-link" href="#" onclick="goToPage(${i})">${i}</a>
                </li>
            `;
        }

        html += `
            <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                <a class="page-link" href="#" onclick="goToPage(${currentPage + 1})">Next</a>
            </li>
        `;

        document.getElementById('pagination').innerHTML = html;
    }


    function goToPage(page) {
        const totalPages = Math.ceil(filteredData.length / rowsPerPage);
        if (page < 1 || page > totalPages) return;
        renderTable(page);
    }

    document.getElementById('searchInput').addEventListener('input', function () {
        const query = this.value.toLowerCase();
        filteredData = allData.filter(record => {
            const json = record.form16json;
            if (!json) return false;
            return (
                (json.totalTaxableIncomeMatch ?? '').toString().toLowerCase().includes(query) ||
                (json.assessmentYear ?? '').toLowerCase().includes(query) ||
                (json.employeePAN ?? '').toLowerCase().includes(query) ||
                (json.employeeDetails ?? '').toLowerCase().includes(query) ||
                (json.deductorPAN ?? '').toLowerCase().includes(query) ||
                (json.deductorTAN ?? '').toLowerCase().includes(query)
            );
        });
        renderTable(1);
    });

    renderTable(1);
</script>
@endsection
{{-- <td>
    <a href="${pdfLink}" class="btn btn-sm btn-primary" download>
        Download PDF
    </a>
</td> --}}