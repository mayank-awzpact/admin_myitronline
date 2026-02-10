@extends('backend.app')
@section('content')
    <div class="bulk-mail-create-wrapper">
        <!-- Page Header -->
        <div class="page-header-card">
            <div class="header-content">
                <div class="header-icon-wrapper">
                    <div class="header-icon">
                        <i class="bi bi-envelope-plus-fill" style="font-size: 1.2rem; color:black;"></i>
                    </div>
                </div>
                <div class="header-text">
                    <h1 class="header-title">Create Bulk Mail</h1>
                    <p class="header-subtitle">Compose and send emails to multiple recipients efficiently</p>
                </div>
            </div>
            <div class="header-decoration">
                <div class="decoration-circle"></div>
                <div class="decoration-circle"></div>
                <div class="decoration-circle"></div>
            </div>
        </div>

        <!-- Error Alert -->
        @if ($errors->any())
            <div class="error-alert-card">
                <div class="alert-icon">
                    <i class="bi bi-exclamation-triangle-fill" style="font-size: 1rem;"></i>
                </div>
                <div class="alert-content">
                    <h6 class="alert-title">Please fix the following errors:</h6>
                    <ul class="error-list">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button type="button" class="alert-close" onclick="this.parentElement.style.display='none'">
                    <i class="bi bi-x-lg" style="font-size: 0.9rem;"></i>
                </button>
            </div>
        @endif

        <!-- Main Form Card -->
        <div class="form-main-card">
            <form action="{{ route('bulkmail.store') }}" method="POST" enctype="multipart/form-data" id="bulkMailForm">
                @csrf
                <!-- Form Header -->
                <div class="form-header">
                    <div class="form-progress">
                        <div class="progress-line"></div>
                        <div class="progress-steps">
                            <div class="step-item active" data-step="1">
                                <div class="step-circle">
                                    <i class="bi bi-person-lines-fill" style="font-size: 0.9rem;"></i>
                                </div>
                                <span class="step-label">Sender & Recipients</span>
                            </div>
                            <div class="step-item" data-step="2">
                                <div class="step-circle">
                                    <i class="bi bi-calendar-event" style="font-size: 0.9rem;"></i>
                                </div>
                                <span class="step-label">Details & Media</span>
                            </div>
                            <div class="step-item" data-step="3">
                                <div class="step-circle">
                                    <i class="bi bi-chat-text-fill" style="font-size: 0.9rem;"></i>
                                </div>
                                <span class="step-label">Content</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <div class="form-content">
                    <!-- Section 1: Sender & Recipients -->
                    <div class="form-section active" data-section="1">
                        <div class="section-header">
                            <h4><i class="bi bi-person-lines-fill me-2" style="font-size: 1rem;"></i>Sender & Recipients
                            </h4>
                            <p>Configure who will send and receive this bulk mail</p>
                        </div>
                        <div class="row g-4">
                            <!-- Sender Email -->
                            <div class="col-lg-6">
                                <div class="input-group-enhanced">
                                    <label for="sender_mail" class="input-label">
                                        <i class="bi bi-person-circle me-2" style="font-size: 0.9rem;"></i>
                                        Sender Email
                                        <span class="required-star">*</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <div class="input-icon">
                                            <i class="bi bi-envelope" style="font-size: 0.8rem;"></i>
                                        </div>
                                        <input type="email" name="sender_mail" id="sender_mail" class="form-input"
                                            placeholder="sender@example.com" value="{{ old('sender_mail') }}" required>
                                        <div class="input-focus-border"></div>
                                    </div>
                                    <div class="input-help">This email will appear as the sender</div>
                                </div>
                            </div>

                            <!-- Recipients -->
                            <div class="col-lg-6">
                                <div class="input-group-enhanced">
                                    <label class="input-label">
                                        <i class="bi bi-people me-2" style="font-size: 0.9rem;"></i>
                                        Recipients
                                        <span class="required-star">*</span>
                                    </label>

                                    <!-- Input Method Toggle -->
                                    <div class="method-toggle">
                                        <button type="button" class="toggle-btn active" data-method="manual"
                                            id="manualToggle">
                                            <i class="bi bi-keyboard me-1" style="font-size: 0.8rem;"></i>
                                            Manual Entry
                                        </button>
                                        <button type="button" class="toggle-btn" data-method="csv" id="csvToggle">
                                            <i class="bi bi-file-earmark-spreadsheet me-1" style="font-size: 0.8rem;"></i>
                                            CSV Upload
                                        </button>
                                    </div>

                                    <!-- Manual Entry -->
                                    <div class="input-method active" data-method="manual" id="manualMethod">
                                        <div id="user-mail-group" class="email-inputs">
                                            <div class="email-input-row">
                                                <div class="input-wrapper">
                                                    <div class="input-icon">
                                                        <i class="bi bi-envelope" style="font-size: 0.8rem;"></i>
                                                    </div>
                                                    <input type="email" name="user_mail[]"
                                                        class="form-input manual-email"
                                                        placeholder="recipient@example.com">
                                                    <button type="button" class="add-email-btn"
                                                        title="Add another email">
                                                        <i class="bi bi-plus-lg" style="font-size: 0.8rem;"></i>
                                                    </button>
                                                    <div class="input-focus-border"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn-add-more" id="addMoreEmails">
                                            <i class="bi bi-plus-circle me-1" style="font-size: 0.8rem;"></i>
                                            Add Another Email
                                        </button>
                                    </div>

                                    <!-- CSV Upload -->
                                    <div class="input-method" data-method="csv" id="csvMethod" style="display: none;">
                                        <div class="file-upload-zone" id="csvUploadZone">
                                            <div class="upload-icon">
                                                <i class="bi bi-cloud-upload" style="font-size: 2rem;"></i>
                                            </div>
                                            <div class="upload-text">
                                                <h6>Upload CSV File</h6>
                                                <p>Drag and drop or click to select</p>
                                            </div>
                                            <input type="file" name="email_csv" id="email_csv" class="file-input"
                                                accept=".csv,.txt">
                                            <label for="email_csv" class="file-label">
                                                <i class="bi bi-folder2-open me-1" style="font-size: 0.8rem;"></i>
                                                Choose File
                                            </label>
                                            <div class="file-info">
                                                <small><i class="bi bi-info-circle me-1"
                                                        style="font-size: 0.8rem;"></i>CSV with one email per line or
                                                    column</small>
                                            </div>
                                        </div>

                                        <!-- CSV Preview -->
                                        <div class="csv-preview" id="csvPreview" style="display: none;">
                                            <div class="csv-preview-header">
                                                <div class="preview-title">
                                                    <i class="bi bi-eye me-1" style="font-size: 0.8rem;"></i>
                                                    CSV Preview
                                                </div>
                                                <div class="preview-actions">
                                                    <div class="email-counter">
                                                        <span class="counter-badge">
                                                            <span id="csvEmailCount">0</span> emails found
                                                        </span>
                                                    </div>
                                                    <button type="button" class="btn-clear-csv" id="clearCsv">
                                                        <i class="bi bi-x-circle me-1" style="font-size: 0.8rem;"></i>
                                                        Clear
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="csv-preview-content">
                                                <div class="email-list" id="csvEmailList"></div>
                                            </div>
                                        </div>

                                        <!-- Hidden inputs for CSV emails -->
                                        <div id="csvEmailInputs"></div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Details & Media -->
                    <div class="form-section" data-section="2">
                        <div class="section-header">
                            <h4><i class="bi bi-calendar-event me-2" style="font-size: 1rem;"></i>Details & Media</h4>
                            <p>Set the schedule and add visual elements</p>
                        </div>
                        <div class="row g-4">
                            <!-- Date -->
                            <div class="col-lg-6">
                                <div class="input-group-enhanced">
                                    <label for="date" class="input-label">
                                        <i class="bi bi-calendar3 me-2" style="font-size: 0.9rem;"></i>
                                        Send Date
                                        <span class="required-star">*</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <div class="input-icon">
                                            <i class="bi bi-calendar-event" style="font-size: 0.8rem;"></i>
                                        </div>
                                        <input type="date" name="date" id="date" class="form-input"
                                            value="{{ old('date') ?? date('Y-m-d') }}" required>
                                        <div class="input-focus-border"></div>
                                    </div>
                                    <div class="input-help">When should this email be sent?</div>
                                </div>
                            </div>

                            <!-- Image URL -->
                            <div class="col-lg-6">
                                <div class="input-group-enhanced">
                                    <label for="img_url" class="input-label">
                                        <i class="bi bi-image me-2" style="font-size: 0.9rem;"></i>
                                        Header Image URL
                                        <span class="required-star">*</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <div class="input-icon">
                                            <i class="bi bi-link-45deg" style="font-size: 0.8rem;"></i>
                                        </div>
                                        <input type="url" name="img_url" id="img_url" class="form-input"
                                            placeholder="https://example.com/image.jpg" value="{{ old('img_url') }}"
                                            required>
                                        <button type="button" class="preview-btn" id="previewImage"
                                            title="Preview Image">
                                            <i class="bi bi-eye" style="font-size: 0.8rem;"></i>
                                        </button>
                                        <div class="input-focus-border"></div>
                                    </div>
                                    <div class="input-help">URL of the header image for your email</div>
                                    <!-- Image Preview -->
                                    <div class="image-preview-container" id="imagePreview" style="display: none;">
                                        <img id="previewImg" src="/placeholder.svg" alt="Preview"
                                            class="preview-image">
                                        <button type="button" class="close-preview" onclick="closePreview()">
                                            <i class="bi bi-x" style="font-size: 0.8rem;"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Content -->
                    <div class="form-section" data-section="3">
                        <div class="section-header">
                            <h4><i class="bi bi-chat-text-fill me-2" style="font-size: 1rem;"></i>Email Content</h4>
                            <p>Compose your email message and subject</p>
                        </div>
                        <div class="row g-4">
                            <!-- Mail Heading -->
                            <div class="col-lg-6">
                                <div class="input-group-enhanced">
                                    <label for="mail_heading" class="input-label">
                                        <i class="bi bi-type-h1 me-2" style="font-size: 0.9rem;"></i>
                                        Mail Heading
                                        <span class="required-star">*</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <div class="input-icon">
                                            <i class="bi bi-fonts" style="font-size: 0.8rem;"></i>
                                        </div>
                                        <input type="text" name="mail_heading" id="mail_heading" class="form-input"
                                            placeholder="Enter email heading" value="{{ old('mail_heading') }}" required>
                                        <div class="input-focus-border"></div>
                                    </div>
                                    <div class="input-help">Main heading displayed in the email</div>
                                </div>
                            </div>

                            <!-- Subject -->
                            <div class="col-lg-6">
                                <div class="input-group-enhanced">
                                    <label for="subject" class="input-label">
                                        <i class="bi bi-chat-square-text me-2" style="font-size: 0.9rem;"></i>
                                        Email Subject
                                        <span class="required-star">*</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <div class="input-icon">
                                            <i class="bi bi-envelope-open" style="font-size: 0.8rem;"></i>
                                        </div>
                                        <input type="text" name="subject" id="subject" class="form-input"
                                            placeholder="Enter email subject" value="{{ old('subject') }}" required>
                                        <div class="char-counter">
                                            <span id="charCount">0</span>/100
                                        </div>
                                        <div class="input-focus-border"></div>
                                    </div>
                                    <div class="input-help">Subject line recipients will see</div>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="col-12">
                                <div class="input-group-enhanced">
                                    <label for="description" class="input-label">
                                        <i class="bi bi-card-text me-2" style="font-size: 0.9rem;"></i>
                                        Email Message
                                        <span class="required-star">*</span>
                                    </label>
                                    <div class="textarea-wrapper">
                                        <div class="editor-toolbar">
                                            <button type="button" class="toolbar-btn" data-action="bold"
                                                title="Bold">
                                                <i class="bi bi-type-bold" style="font-size: 0.8rem;"></i>
                                            </button>
                                            <button type="button" class="toolbar-btn" data-action="italic"
                                                title="Italic">
                                                <i class="bi bi-type-italic" style="font-size: 0.8rem;"></i>
                                            </button>
                                            <button type="button" class="toolbar-btn" data-action="underline"
                                                title="Underline">
                                                <i class="bi bi-type-underline" style="font-size: 0.8rem;"></i>
                                            </button>
                                            <div class="toolbar-divider"></div>
                                            <button type="button" class="toolbar-btn" data-action="list"
                                                title="Bullet List">
                                                <i class="bi bi-list-ul" style="font-size: 0.8rem;"></i>
                                            </button>
                                            <button type="button" class="toolbar-btn" data-action="link"
                                                title="Insert Link">
                                                <i class="bi bi-link" style="font-size: 0.8rem;"></i>
                                            </button>
                                        </div>
                                        <textarea name="description" id="description" class="form-textarea" rows="6"
                                            placeholder="Compose your email message here..." required>{{ old('description') }}</textarea>
                                        <div class="textarea-focus-border"></div>
                                    </div>
                                    <div class="input-help">
                                        <i class="bi bi-lightbulb me-1" style="font-size: 0.8rem;"></i>
                                        Tip: Keep your message clear and engaging for better response rates
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Footer -->
                <div class="form-footer">
                    <div class="footer-left">
                        <a href="{{ route('bulkmail.index') }}" class="btn btn-secondary-outline">
                            <i class="bi bi-arrow-left me-1" style="font-size: 0.8rem;"></i>
                            Back to List
                        </a>
                    </div>
                    <div class="footer-center">
                        <div class="form-navigation">
                            <button type="button" class="btn btn-nav" id="prevBtn" style="display: none;">
                                <i class="bi bi-chevron-left me-1" style="font-size: 0.8rem;"></i>
                                Previous
                            </button>
                            <button type="button" class="btn btn-nav btn-primary" id="nextBtn">
                                Next
                                <i class="bi bi-chevron-right ms-1" style="font-size: 0.8rem;"></i>
                            </button>
                        </div>
                    </div>
                    <div class="footer-right">
                        <button type="submit" class="btn btn-success-gradient" id="submitBtn" style="display: none;">
                            <i class="bi bi-send-check me-1" style="font-size: 0.8rem;"></i>
                            Create & Send
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<script src="{{ asset('js/bulkcreate.js') }}"></script>
@endsection
