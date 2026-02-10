@extends('backend.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm bg-gradient-seo text-white">
                    <div class="card-body py-4">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-1 fw-bold">
                                    <i class="bi bi-pencil-square-fill me-2"></i>
                                    Edit SEO Meta
                                </h3>
                                <p class="mb-0 opacity-75">Update SEO metadata to improve search engine visibility</p>
                            </div>
                            <div class="col-auto">
                                <div class="bg-white bg-opacity-20 rounded-pill px-3 py-2">
                                    <i class="bi bi-gear-fill me-1"></i>
                                    <span class="fw-semibold">SEO Editor</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <form method="POST" action="{{ route('services.meta_update', $meta->id) }}" id="metaEditForm">
                    @csrf

                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light border-0 py-3">
                            <h5 class="mb-0 fw-semibold">
                                <i class="bi bi-gear-fill text-primary me-2"></i>
                                Service & Domain Configuration
                            </h5>
                            <small class="text-muted">Update the service and domain for this SEO meta</small>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="service_id" class="form-label fw-semibold">
                                        <i class="bi bi-list-ul me-1"></i>Select Service
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="select-wrapper">
                                        <select name="service_id" id="service_id"
                                            class="form-select form-select-lg modern-select" required>
                                            <option value="">Choose a service...</option>
                                            @foreach ($services as $service)
                                                <option value="{{ $service->uniqueId }}"
                                                    {{ $meta->service_id == $service->uniqueId ? 'selected' : '' }}>
                                                    {{ $service->serviceHeading }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <i class="bi bi-chevron-down select-icon"></i>
                                    </div>
                                    <div class="form-text">Select the service this SEO meta belongs to</div>
                                </div>

                                <div class="col-md-6">
                                    <label for="domain_id" class="form-label fw-semibold">
                                        <i class="bi bi-globe me-1"></i>Select Domain
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="select-wrapper">
                                        <select name="domain_id" id="domain_id"
                                            class="form-select form-select-lg modern-select" required>
                                            <option value="">Choose a domain...</option>
                                            <option value="1" {{ $meta->domain_id == 1 ? 'selected' : '' }}>
                                                myitronline.com
                                            </option>
                                            <option value="2" {{ $meta->domain_id == 2 ? 'selected' : '' }}>
                                                clarityefiling.com
                                            </option>
                                            <option value="3" {{ $meta->domain_id == 3 ? 'selected' : '' }}>
                                                taxa23.com
                                            </option>
                                            <option value="4" {{ $meta->domain_id == 4 ? 'selected' : '' }}>
                                                eitrfiling.com
                                            </option>
                                        </select>
                                        <i class="bi bi-chevron-down select-icon"></i>
                                    </div>
                                    <div class="form-text">Choose the domain where this meta will be used</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light border-0 py-3">
                            <h5 class="mb-0 fw-semibold">
                                <i class="bi bi-search text-success me-2"></i>
                                SEO Meta Information
                            </h5>
                            <small class="text-muted">Update SEO metadata for better search engine ranking</small>
                        </div>
                        <div class="card-body p-4">
                            <div class="alert alert-info border-0 mb-4">
                                <i class="bi bi-lightbulb me-2"></i>
                                <strong>SEO Tips:</strong> Keep your title under 60 characters and description under 160
                                characters for optimal search engine display.
                            </div>

                            <div class="row g-4">
                                <div class="col-12">
                                    <label for="metaTitle" class="form-label fw-semibold">
                                        <i class="bi bi-type-h1 me-1"></i>Meta Title
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="metaTitle" id="metaTitle"
                                        class="form-control form-control-lg"
                                        value="{{ old('metaTitle', $meta->metaTitle) }}" maxlength="60" required>
                                    <div class="form-text d-flex justify-content-between">
                                        <span>This appears as the clickable headline in search results</span>
                                        <span id="titleCounter" class="text-muted">0/60 characters</span>
                                    </div>
                                    <div class="progress mt-2" style="height: 3px;">
                                        <div id="titleProgress" class="progress-bar bg-success" role="progressbar"
                                            style="width: 0%"></div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="metaKeyword" class="form-label fw-semibold">
                                        <i class="bi bi-tags me-1"></i>Meta Keywords
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="metaKeyword" id="metaKeyword"
                                        class="form-control form-control-lg"
                                        value="{{ old('metaKeyword', $meta->metaKeyword) }}" required>
                                    <div class="form-text">Separate keywords with commas. Focus on 5-10 relevant keywords
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="metaDescription" class="form-label fw-semibold">
                                        <i class="bi bi-card-text me-1"></i>Meta Description
                                        <span class="text-danger">*</span>
                                    </label>
                                    <textarea name="metaDescription" id="metaDescription" class="form-control" rows="4" maxlength="160" required>{{ old('metaDescription', $meta->metaDescription) }}</textarea>
                                    <div class="form-text d-flex justify-content-between">
                                        <span>This appears as the description snippet in search results</span>
                                        <span id="descCounter" class="text-muted">0/160 characters</span>
                                    </div>
                                    <div class="progress mt-2" style="height: 3px;">
                                        <div id="descProgress" class="progress-bar bg-success" role="progressbar"
                                            style="width: 0%"></div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="tag" class="form-label fw-semibold">
                                        <i class="bi bi-hash me-1"></i>Content Tags
                                        <span class="text-danger">*</span>
                                    </label>
                                    <textarea name="tag" id="tag" class="form-control" rows="3" required>{{ old('tag', $meta->tag) }}</textarea>
                                    <div class="form-text">Add relevant tags for content categorization and internal
                                        organization</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light border-0 py-3">
                            <h5 class="mb-0 fw-semibold">
                                <i class="bi bi-eye text-info me-2"></i>
                                Search Result Preview
                            </h5>
                            <small class="text-muted">See how your updated meta will appear in search results</small>
                        </div>
                        <div class="card-body p-4">
                            <div class="search-preview">
                                <div class="preview-url">
                                    <span id="previewDomain">Loading domain...</span>
                                </div>
                                <div class="preview-title">
                                    <span id="previewTitle">{{ $meta->metaTitle }}</span>
                                </div>
                                <div class="preview-description">
                                    <span id="previewDescription">{{ $meta->metaDescription }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <button type="submit" class="btn btn-success btn-lg px-5 me-3">
                                        <i class="bi bi-check-circle-fill me-2"></i>Update SEO Meta
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
