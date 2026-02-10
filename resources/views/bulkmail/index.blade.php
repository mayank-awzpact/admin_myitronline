@extends('backend.app')
@section('content')
    <div class="bulk-mail-container">
        <!-- Page Header -->
        <div class="page-header">
            <div class="header-content">
                <div class="header-icon">
                    <i class="bi bi-envelope-paper" style="font-size: 1rem; color:black;"></i>
                </div>
                <div class="header-text">
                    <h1 class="page-title">Bulk Mail Management</h1>
                    <p class="page-subtitle">Manage and send bulk emails efficiently</p>
                </div>
            </div>
            <div class="header-actions">
                <a href="{{ route('bulkmail.create') }}" class="btn btn-primary-modern">
                    <i class="bi bi-plus-circle me-2" style="font-size: 0.8rem;"></i>
                    Create New Mail
                </a>
            </div>
        </div>

        <!-- Alert Messages -->
        @if (session('success'))
            <div class="alert alert-success-modern" id="successAlert">
                <div class="alert-icon">
                    <i class="bi bi-check-circle-fill" style="font-size: 1rem;"></i>
                </div>
                <div class="alert-content">
                    <strong>Success!</strong>
                    <p>{{ session('success') }}</p>
                </div>
                <button type="button" class="alert-close" onclick="closeAlert('successAlert')">
                    <i class="bi bi-x" style="font-size: 1rem;"></i>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger-modern" id="errorAlert">
                <div class="alert-icon">
                    <i class="bi bi-exclamation-triangle-fill" style="font-size: 1rem;"></i>
                </div>
                <div class="alert-content">
                    <strong>Error!</strong>
                    <p>{{ session('error') }}</p>
                </div>
                <button type="button" class="alert-close" onclick="closeAlert('errorAlert')">
                    <i class="bi bi-x" style="font-size: 1rem;"></i>
                </button>
            </div>
        @endif

        <!-- Main Content Card -->
        <div class="content-card">
            <!-- Search and Filter Section -->
            <div class="filter-section">
                <form method="GET" action="{{ route('bulkmail.index') }}" class="filter-form">
                    <div class="filter-row">
                        <div class="filter-group">
                            <label class="filter-label">Search</label>
                            <div class="input-with-icon">
                                <i class="bi bi-search input-icon" style="font-size: 0.8rem;"></i>
                                <input type="text" name="search" class="form-control-modern"
                                    placeholder="Search by email or subject..." value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="filter-group">
                            <label class="filter-label">Date</label>
                            <div class="input-with-icon">
                                <i class="bi bi-calendar3 input-icon" style="font-size: 0.8rem;"></i>
                                <input type="date" name="date" class="form-control-modern"
                                    value="{{ request('date') }}">
                            </div>
                        </div>
                        <div class="filter-actions">
                            <button type="submit" class="btn btn-filter">
                                <i class="bi bi-funnel me-1" style="font-size: 0.8rem;"></i>
                                Filter
                            </button>
                            <a href="{{ route('bulkmail.index') }}" class="btn btn-reset">
                                <i class="bi bi-arrow-clockwise me-1" style="font-size: 0.8rem;"></i>
                                Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Bulk Actions Section -->
            <form action="{{ route('bulkmail.send.bulk_mail') }}" method="POST" id="bulkMailForm">
                @csrf
                <input type="hidden" id="selected_ids" name="selected_ids">
                <div class="bulk-actions-bar">
                    <div class="selection-info">
                        <div class="selection-controls">
                            <button type="button" class="btn btn-select-all" id="toggleCheckboxes">
                                <i class="bi bi-check-square me-1" style="font-size: 0.8rem;"></i>
                                <span id="toggleText">Select All</span>
                            </button>
                            <div class="selection-count">
                                <span class="count-badge">
                                    <span id="selectedCount">0</span> selected
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="bulk-actions">
                        <button type="submit" class="btn btn-send-bulk" id="sendBulkBtn" disabled>
                            <i class="bi bi-send-fill me-1" style="font-size: 0.8rem;"></i>
                            Send Selected
                        </button>
                    </div>
                </div>

                <div class="table-container">
                    <div class="table-wrapper">
                        <table class="enhanced-table">
                            <thead>
                                <tr>
                                    <th class="checkbox-col">
                                        <div class="checkbox-wrapper">
                                            <input type="checkbox" id="masterCheckbox" class="checkbox-modern">
                                            <label for="masterCheckbox" class="sr-only">Select All</label>
                                        </div>
                                    </th>
                                    <th class="number-col">#</th>
                                    <th class="sender-col">
                                        <div class="th-content text-white">
                                            <i class="bi bi-person-circle me-1" style="font-size: 0.8rem;"></i>
                                            Sender
                                        </div>
                                    </th>
                                    <th class="recipient-col text-white">
                                        <div class="th-content">
                                            <i class="bi bi-envelope me-1" style="font-size: 0.8rem;"></i>
                                            Recipient
                                        </div>
                                    </th>
                                    <th class="date-col text-white">
                                        <div class="th-content">
                                            <i class="bi bi-calendar3 me-1" style="font-size: 0.8rem;"></i>
                                            Date
                                        </div>
                                    </th>
                                    <th class="subject-col text-white">
                                        <div class="th-content">
                                            <i class="bi bi-chat-text me-1" style="font-size: 0.8rem;"></i>
                                            Subject
                                        </div>
                                    </th>
                                    <th class="action-col text-white">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($mails as $index => $mail)
                                    <tr class="table-row" data-id="{{ $mail->id }}">
                                        <td class="checkbox-cell">
                                            <div class="checkbox-wrapper">
                                                <input type="checkbox" id="checkbox-{{ $mail->id }}"
                                                    class="mail-checkbox checkbox-modern" data-id="{{ $mail->id }}">
                                                <label for="checkbox-{{ $mail->id }}" class="sr-only">Select
                                                    mail</label>
                                            </div>
                                        </td>
                                        <td class="number-cell">
                                            <span
                                                class="row-number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                        </td>
                                        <td class="sender-cell">
                                            <div class="user-info">
                                                <div class="user-details">
                                                    <div class="user-email">{{ $mail->sender_mail }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="recipient-cell">
                                            <div class="recipient-info">
                                                <div class="recipient-email">{{ $mail->user_mail }}</div>
                                            </div>
                                        </td>
                                        <td class="date-cell">
                                            <div class="date-info">
                                                <div class="date-primary">
                                                    {{ \Carbon\Carbon::parse($mail->date)->format('M d, Y') }}</div>
                                                <div class="date-secondary">
                                                    {{ \Carbon\Carbon::parse($mail->date)->format('h:i A') }}</div>
                                            </div>
                                        </td>
                                        <td class="subject-cell">
                                            <div class="subject-content">
                                                <div class="subject-text" title="{{ $mail->subject }}">
                                                    {{ Str::limit($mail->subject, 40) }}
                                                </div>
                                                @if (strlen($mail->subject) > 40)
                                                    <div class="subject-tooltip">{{ $mail->subject }}</div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="action-cell">
                                            <div class="action-buttons">
                                                <a href="{{ route('bulkmail.edit', Crypt::encryptString($mail->id)) }}"
                                                    class="btn btn-action btn-edit" title="Edit Mail">
                                                    <i class="bi bi-pencil-square" style="font-size: 0.8rem;"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="empty-row">
                                        <td colspan="7" class="empty-cell">
                                            <div class="empty-state">
                                                <div class="empty-icon">
                                                    <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                                                </div>
                                                <div class="empty-content">
                                                    <h6>No bulk mails found</h6>
                                                    <p>Create your first bulk mail to get started</p>
                                                    <a href="{{ route('bulkmail.create') }}"
                                                        class="btn btn-primary-modern mt-3">
                                                        <i class="bi bi-plus-circle me-1" style="font-size: 0.8rem;"></i>
                                                        Create New Mail
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>

            <!-- Pagination -->
            @if (method_exists($mails, 'links'))
                <div class="pagination-wrapper">
                    {{ $mails->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Enhanced Loader Overlay -->
    <div id="loaderOverlay" class="loader-overlay">
        <div class="loader-content">
            <div class="loader-spinner">
                <div class="spinner-ring"></div>
                <div class="spinner-ring"></div>
                <div class="spinner-ring"></div>
            </div>
            <div class="loader-text">
                <h5>Sending Bulk Mails</h5>
                <p>Please wait while we process your request...</p>
                <div class="progress-bar">
                    <div class="progress-fill"></div>
                </div>
            </div>
        </div>
    </div>

   <script src="{{ asset('js/bulkindex.js') }}"></script>
@endsection
