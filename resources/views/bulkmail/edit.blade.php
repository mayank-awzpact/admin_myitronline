@extends('backend.app')

@section('content')
    <div class="bulk-mail-edit-wrapper">
        <!-- Page Header -->
        <div class="page-header-card">
            <div class="header-content">
                <div class="header-icon-wrapper">
                    <div class="header-icon">
                        <i class="bi bi-pencil-square" style="color:black"></i>
                    </div>
                    <div class="edit-badge">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                </div>
                <div class="header-text">
                    <h1 class="header-title">Edit Bulk Mail</h1>
                    <p class="header-subtitle">Update and modify your bulk email campaign</p>
                    <div class="mail-info">
                        <span class="info-item">
                            <i class="bi bi-calendar3 me-1"></i>
                            Created: {{ \Carbon\Carbon::parse($mail->created_at)->format('M d, Y') }}
                        </span>
                        <span class="info-item">
                            <i class="bi bi-clock me-1"></i>
                            Last Updated: {{ \Carbon\Carbon::parse($mail->updated_at)->diffForHumans() }}
                        </span>
                    </div>
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
                    <i class="bi bi-exclamation-triangle-fill"></i>
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
                    <i class="bi bi-x-lg fs-6"></i>
                </button>
            </div>
        @endif



        <!-- Main Form Card -->
        <div class="form-main-card">
            <form action="{{ route('bulkmail.update', Crypt::encryptString($mail->id)) }}" method="POST"
                enctype="multipart/form-data" id="bulkMailEditForm">
                @csrf
                @method('PUT')

                <!-- Form Header -->
                <div class="form-header">
                    <div class="form-progress">
                        <div class="progress-line"></div>
                        <div class="progress-steps">
                            <div class="step-item active" data-step="1">
                                <div class="step-circle">
                                    <i class="bi bi-person-lines-fill"></i>
                                </div>
                                <span class="step-label">Sender & Recipients</span>
                            </div>
                            <div class="step-item" data-step="2">
                                <div class="step-circle">
                                    <i class="bi bi-calendar-event"></i>
                                </div>
                                <span class="step-label">Details & Media</span>
                            </div>
                            <div class="step-item" data-step="3">
                                <div class="step-circle">
                                    <i class="bi bi-chat-text-fill"></i>
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
                            <h4><i class="bi bi-person-lines-fill me-2"></i>Sender & Recipients</h4>
                            <p>Update who will send and receive this bulk mail</p>
                        </div>

                        <div class="row g-4">
                            <!-- Sender Email -->
                            <div class="col-lg-6">
                                <div class="input-group-enhanced">
                                    <label for="sender_mail" class="input-label">
                                        <i class="bi bi-person-circle me-2"></i>
                                        Sender Email
                                        <span class="required-star">*</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <div class="input-icon">
                                            <i class="bi bi-envelope"></i>
                                        </div>
                                        <input type="email" name="sender_mail" id="sender_mail" class="form-input"
                                            placeholder="sender@example.com"
                                            value="{{ old('sender_mail', $mail->sender_mail) }}" required>
                                        <div class="input-focus-border"></div>
                                    </div>
                                    <div class="input-help">This email will appear as the sender</div>
                                    <div class="current-value">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Current: {{ $mail->sender_mail }}
                                    </div>
                                </div>
                            </div>

                            <!-- User Email -->
                            <div class="col-lg-6">
                                <div class="input-group-enhanced">
                                    <label for="user_mail" class="input-label">
                                        <i class="bi bi-people me-2"></i>
                                        Recipient Email
                                        <span class="required-star">*</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <div class="input-icon">
                                            <i class="bi bi-envelope-open"></i>
                                        </div>
                                        <input type="email" name="user_mail" id="user_mail" class="form-input"
                                            placeholder="recipient@example.com"
                                            value="{{ old('user_mail', $mail->user_mail) }}" required>
                                        <div class="input-focus-border"></div>
                                    </div>
                                    <div class="input-help">Email address of the recipient</div>
                                    <div class="current-value">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Current: {{ $mail->user_mail }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Details & Media -->
                    <div class="form-section" data-section="2">
                        <div class="section-header">
                            <h4><i class="bi bi-calendar-event me-2"></i>Details & Media</h4>
                            <p>Update the schedule and visual elements</p>
                        </div>

                        <div class="row g-4">
                            <!-- Date -->
                            <div class="col-lg-6">
                                <div class="input-group-enhanced">
                                    <label for="date" class="input-label">
                                        <i class="bi bi-calendar3 me-2"></i>
                                        Send Date
                                        <span class="required-star">*</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <div class="input-icon">
                                            <i class="bi bi-calendar-event"></i>
                                        </div>
                                        <input type="date" name="date" id="date" class="form-input"
                                            value="{{ old('date', $mail->date) }}" required>
                                        <div class="input-focus-border"></div>
                                    </div>
                                    <div class="input-help">When should this email be sent?</div>
                                    <div class="current-value">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Current: {{ \Carbon\Carbon::parse($mail->date)->format('M d, Y') }}
                                    </div>
                                </div>
                            </div>

                            <!-- Image URL -->
                            <div class="col-lg-6">
                                <div class="input-group-enhanced">
                                    <label for="img_url" class="input-label">
                                        <i class="bi bi-image me-2"></i>
                                        Header Image URL
                                        <span class="required-star">*</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <div class="input-icon">
                                            <i class="bi bi-link-45deg"></i>
                                        </div>
                                        <input type="url" name="img_url" id="img_url" class="form-input"
                                            placeholder="https://example.com/image.jpg"
                                            value="{{ old('img_url', $mail->img_url) }}" required>
                                        <button type="button" class="preview-btn" id="previewImage"
                                            title="Preview Image">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <div class="input-focus-border"></div>
                                    </div>
                                    <div class="input-help">URL of the header image for your email</div>

                                    <!-- Current Image Preview -->
                                    <div class="current-image-preview">
                                        <div class="current-label">
                                            <i class="bi bi-image me-1"></i>
                                            Current Image:
                                        </div>
                                        <img src="{{ $mail->img_url }}" alt="Current Image" class="current-img">
                                    </div>

                                    <!-- New Image Preview -->
                                    <div class="image-preview-container" id="imagePreview" style="display: none;">
                                        <div class="preview-label">
                                            <i class="bi bi-eye me-1"></i>
                                            New Image Preview:
                                        </div>
                                        <img id="previewImg" src="/placeholder.svg" alt="Preview"
                                            class="preview-image">
                                        <button type="button" class="close-preview" onclick="closePreview()">
                                            <i class="bi bi-x"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Content -->
                    <div class="form-section" data-section="3">
                        <div class="section-header">
                            <h4><i class="bi bi-chat-text-fill me-2"></i>Email Content</h4>
                            <p>Update your email message and subject</p>
                        </div>

                        <div class="row g-4">
                            <!-- Mail Heading -->
                            <div class="col-lg-6">
                                <div class="input-group-enhanced">
                                    <label for="mail_heading" class="input-label">
                                        <i class="bi bi-type-h1 me-2"></i>
                                        Mail Heading
                                        <span class="required-star">*</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <div class="input-icon">
                                            <i class="bi bi-fonts"></i>
                                        </div>
                                        <input type="text" name="mail_heading" id="mail_heading" class="form-input"
                                            placeholder="Enter email heading"
                                            value="{{ old('mail_heading', $mail->mail_heading) }}" required>
                                        <div class="input-focus-border"></div>
                                    </div>
                                    <div class="input-help">Main heading displayed in the email</div>
                                    <div class="current-value">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Current: "{{ $mail->mail_heading }}"
                                    </div>
                                </div>
                            </div>

                            <!-- Subject -->
                            <div class="col-lg-6">
                                <div class="input-group-enhanced">
                                    <label for="subject" class="input-label">
                                        <i class="bi bi-chat-square-text me-2"></i>
                                        Email Subject
                                        <span class="required-star">*</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <div class="input-icon">
                                            <i class="bi bi-envelope-open"></i>
                                        </div>
                                        <input type="text" name="subject" id="subject" class="form-input"
                                            placeholder="Enter email subject"
                                            value="{{ old('subject', $mail->subject) }}" required>
                                        <div class="char-counter">
                                            <span id="charCount">{{ strlen($mail->subject) }}</span>/100
                                        </div>
                                        <div class="input-focus-border"></div>
                                    </div>
                                    <div class="input-help">Subject line recipients will see</div>
                                    <div class="current-value">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Current: "{{ $mail->subject }}"
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="col-12">
                                <div class="input-group-enhanced">
                                    <label for="description" class="input-label">
                                        <i class="bi bi-card-text me-2"></i>
                                        Email Message
                                        <span class="required-star">*</span>
                                    </label>
                                    <div class="textarea-wrapper">
                                        <div class="editor-toolbar">
                                            <button type="button" class="toolbar-btn" data-action="bold"
                                                title="Bold">
                                                <i class="bi bi-type-bold"></i>
                                            </button>
                                            <button type="button" class="toolbar-btn" data-action="italic"
                                                title="Italic">
                                                <i class="bi bi-type-italic"></i>
                                            </button>
                                            <button type="button" class="toolbar-btn" data-action="underline"
                                                title="Underline">
                                                <i class="bi bi-type-underline"></i>
                                            </button>
                                            <div class="toolbar-divider"></div>
                                            <button type="button" class="toolbar-btn" data-action="list"
                                                title="Bullet List">
                                                <i class="bi bi-list-ul"></i>
                                            </button>
                                            <button type="button" class="toolbar-btn" data-action="link"
                                                title="Insert Link">
                                                <i class="bi bi-link"></i>
                                            </button>
                                            <div class="toolbar-divider"></div>
                                            <button type="button" class="toolbar-btn" id="resetContent"
                                                title="Reset to Original">
                                                <i class="bi bi-arrow-clockwise"></i>
                                            </button>
                                        </div>
                                        <textarea name="description" id="description" class="form-textarea" rows="6"
                                            placeholder="Compose your email message here..." required>{{ old('description', $mail->description) }}</textarea>
                                        <div class="textarea-focus-border"></div>
                                    </div>
                                    <div class="input-help">
                                        <i class="bi bi-lightbulb me-1"></i>
                                        Tip: Keep your message clear and engaging for better response rates
                                    </div>
                                    <div class="current-value">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Original message length: {{ strlen($mail->description) }} characters
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
                            <i class="bi bi-arrow-left me-1"></i>
                            Back to List
                        </a>
                    </div>

                    <div class="footer-center">
                        <div class="form-navigation">
                            <button type="button" class="btn btn-nav" id="prevBtn" style="display: none;">
                                <i class="bi bi-chevron-left me-1"></i>
                                Previous
                            </button>
                            <button type="button" class="btn btn-nav btn-primary" id="nextBtn">
                                Next
                                <i class="bi bi-chevron-right ms-1"></i>
                            </button>
                        </div>
                    </div>

                    <div class="footer-right">
                        <div class="update-actions" id="updateActions">
                            <button type="submit" class="btn btn-success-gradient" id="submitBtn">
                                <i class="bi bi-save2 me-1"></i>
                                Update Mail
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
<script src="{{ asset('js/bulkcreate.js') }}"></script>
@endsection
