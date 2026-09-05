@php
    $isEdit = isset($event) && $event;

    $val = function ($field, $default = null) use ($isEdit, $event) {
        return old($field, $isEdit ? ($event->{$field} ?? $default) : $default);
    };
@endphp

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show shadow-sm">
        <i class="bi bi-exclamation-triangle me-2"></i><strong>Please fix the following:</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm">
        <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label fw-semibold">Event Title <span class="text-danger">*</span></label>
        <input type="text" name="eventTitle" id="eventTitle" class="form-control"
            placeholder="e.g. Diwali Celebration 2026" value="{{ $val('eventTitle') }}" required>
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Slug (URL Alias)</label>
        <input type="text" name="eventSlug" id="eventSlug" class="form-control"
            placeholder="Auto generated from title if left blank" value="{{ $val('eventSlug') }}">
        <small class="text-muted">Used by the website URL. Kept unique automatically.</small>
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Event Type <span class="text-danger">*</span></label>
        <select name="eventType" class="form-select" required>
            @foreach ($eventTypes as $key => $label)
                <option value="{{ $key }}" {{ $val('eventType', 'event') === $key ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
        <select name="status" class="form-select" required>
            <option value="1" {{ (string) $val('status', 1) === '1' ? 'selected' : '' }}>Active</option>
            <option value="0" {{ (string) $val('status', 1) === '0' ? 'selected' : '' }}>Inactive</option>
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Priority</label>
        <input type="number" name="priority" class="form-control" min="0" placeholder="Lower shows first"
            value="{{ $val('priority') }}">
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Event Date <span class="text-danger">*</span></label>
        <input type="date" name="eventDate" class="form-control"
            value="{{ $val('eventDate') ? \Carbon\Carbon::parse($val('eventDate'))->format('Y-m-d') : '' }}" required>
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">End Date</label>
        <input type="date" name="eventEndDate" class="form-control"
            value="{{ $val('eventEndDate') ? \Carbon\Carbon::parse($val('eventEndDate'))->format('Y-m-d') : '' }}">
        <small class="text-muted">Only for multi-day events.</small>
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Event Time</label>
        <input type="text" name="eventTime" class="form-control" placeholder="e.g. 10:00 AM - 5:00 PM"
            value="{{ $val('eventTime') }}">
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Venue</label>
        <input type="text" name="eventVenue" class="form-control" placeholder="e.g. Head Office, Patparganj Delhi"
            value="{{ $val('eventVenue') }}">
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Employee Name</label>
        <input type="text" name="employeeName" class="form-control"
            placeholder="For birthday / anniversary type events" value="{{ $val('employeeName') }}">
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Banner Image</label>
        <input type="file" name="eventImage" class="form-control" accept="image/*">
        <small class="text-muted">JPG, PNG, GIF or WEBP. Max 5 MB.</small>

        @if ($isEdit && $event->eventImage)
            <div class="d-flex align-items-center gap-3 mt-2">
                <img src="{{ asset($event->eventImage) }}" alt="Banner" class="rounded shadow-sm"
                    style="width:110px;height:75px;object-fit:cover;">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remove_event_image" value="1"
                        id="removeEventImage">
                    <label class="form-check-label text-danger" for="removeEventImage">Remove current image</label>
                </div>
            </div>
        @endif
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Album / Drive URL</label>
        <input type="url" name="driveUrl" class="form-control"
            placeholder="https://drive.google.com/drive/folders/..." value="{{ $val('driveUrl') }}">
        <small class="text-muted">Optional full album link shown as "View all photos" on the website.</small>
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Description</label>
        <textarea name="eventDescription" class="form-control" rows="5"
            placeholder="Write about the event...">{{ $val('eventDescription') }}</textarea>
    </div>

    <div class="col-12">
        <div class="d-flex gap-4 flex-wrap">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="isHoliday" value="1" id="isHoliday"
                    {{ (int) $val('isHoliday', 0) === 1 ? 'checked' : '' }}>
                <label class="form-check-label" for="isHoliday">Mark as Holiday</label>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="isRecurring" value="1" id="isRecurring"
                    {{ (int) $val('isRecurring', 0) === 1 ? 'checked' : '' }}>
                <label class="form-check-label" for="isRecurring">Repeats Every Year</label>
            </div>
        </div>
    </div>
</div>

<hr class="my-4">

<h6 class="fw-bold mb-3"><i class="bi bi-images me-2 text-primary"></i>Event Gallery</h6>

@if ($isEdit && count($media))
    <div class="row g-3 mb-4">
        @foreach ($media as $item)
            <div class="col-md-3 col-sm-4 col-6">
                <div class="card h-100 border shadow-sm">
                    @php $isLink = \Illuminate\Support\Str::startsWith($item->mediaPath, ['http://', 'https://']); @endphp

                    @if ($item->mediaType === 'video')
                        <div class="bg-dark text-white d-flex align-items-center justify-content-center"
                            style="height:120px;">
                            <i class="bi bi-play-circle fs-1"></i>
                        </div>
                    @elseif ($isLink)
                        <img src="{{ $item->mediaPath }}" class="card-img-top"
                            style="height:120px;object-fit:cover;" alt="{{ $item->mediaCaption }}">
                    @else
                        <img src="{{ asset($item->mediaPath) }}" class="card-img-top"
                            style="height:120px;object-fit:cover;" alt="{{ $item->mediaCaption }}">
                    @endif

                    <div class="card-body p-2">
                        <span class="badge {{ $item->mediaType === 'video' ? 'bg-dark' : 'bg-secondary' }}">
                            {{ ucfirst($item->mediaType) }}
                        </span>
                        @if ($isLink)
                            <span class="badge bg-info text-dark">Link</span>
                        @endif
                        @if ($item->mediaCaption)
                            <small class="d-block text-muted mt-1 text-truncate">{{ $item->mediaCaption }}</small>
                        @endif
                    </div>

                    <div class="card-footer p-2 bg-white border-0 d-flex gap-1">
                        <a href="{{ $isLink ? $item->mediaPath : asset($item->mediaPath) }}" target="_blank"
                            rel="noopener" class="btn btn-outline-primary btn-sm flex-fill">
                            <i class="bi bi-eye"></i>
                        </a>
                        <button type="button" class="btn btn-outline-danger btn-sm flex-fill remove-media-btn"
                            data-url="{{ route('events.media.destroy', Crypt::encryptString($item->uniqueId)) }}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label fw-semibold">Upload Photos / Videos</label>
        <input type="file" name="media_files[]" class="form-control" multiple
            accept="image/*,video/mp4,video/webm,video/quicktime">
        <small class="text-muted">
            Select multiple files. Images: JPG, PNG, GIF, WEBP. Videos: MP4, WEBM, MOV. Max 20 MB each.
        </small>
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">External Links</label>
        <small class="d-block text-muted mb-2">
            Add a Google Drive file, YouTube video or a direct image / video URL.
        </small>

        <div id="mediaLinkRows">
            <div class="row g-2 mb-2 media-link-row">
                <div class="col-5">
                    <input type="url" name="media_link_url[]" class="form-control form-control-sm"
                        placeholder="https://...">
                </div>
                <div class="col-3">
                    <select name="media_link_type[]" class="form-select form-select-sm">
                        <option value="image">Image</option>
                        <option value="video">Video</option>
                    </select>
                </div>
                <div class="col-3">
                    <input type="text" name="media_link_caption[]" class="form-control form-control-sm"
                        placeholder="Caption">
                </div>
                <div class="col-1">
                    <button type="button" class="btn btn-outline-danger btn-sm remove-link-row w-100">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
            </div>
        </div>

        <button type="button" id="addLinkRow" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-plus-circle me-1"></i>Add Link
        </button>
    </div>
</div>

<hr class="my-4">

<div class="d-flex gap-2">
    <button type="submit" class="btn btn-primary px-4">
        <i class="bi bi-save me-1"></i>{{ $isEdit ? 'Update Event' : 'Save Event' }}
    </button>
    <a href="{{ route('events.index') }}" class="btn btn-outline-secondary px-4">
        <i class="bi bi-x-circle me-1"></i>Cancel
    </a>
</div>
