@extends('backend.app')

@section('content')
    <div class="container-fluid py-4">
        <!-- Success/Error Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <div class="alert-icon me-3">
                        <i class="bi bi-check-circle-fill fs-4 text-success"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="alert-heading mb-1 fw-bold">Success!</h6>
                        <p class="mb-0">{{ session('success') }}</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <div class="alert-icon me-3">
                        <i class="bi bi-exclamation-triangle-fill fs-4 text-danger"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="alert-heading mb-1 fw-bold">Validation Errors!</h6>
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm bg-gradient-seo text-white">
                    <div class="card-body py-4">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-1 fw-bold">
                                    <i class="bi bi-plus-circle-fill me-2"></i>
                                    Create SEO Meta
                                </h3>
                                <p class="mb-0 opacity-75">Add SEO metadata to improve search engine visibility</p>
                            </div>
                            <div class="col-auto">
                                <div class="bg-white text-black bg-opacity-20 rounded-pill px-3 py-2">
                                    <i class="bi bi-search me-1"></i>
                                    <span class="fw-semibold">SEO Creator</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <form action="{{ route('services.meta_store') }}" method="POST" id="metaForm">
                    @csrf
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light border-0 py-3">
                            <h5 class="mb-0 fw-semibold">
                                <i class="bi bi-gear-fill text-primary me-2"></i>
                                Service & Domain Selection
                            </h5>
                            <small class="text-muted">Choose the service and domain for this SEO meta</small>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">

                                <div class="col-md-6">
                                    <label for="serviceName" class="form-label fw-semibold">
                                        <i class="bi bi-list-ul me-1"></i>Select Service
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="select-wrapper">
                                        <select name="serviceName" id="serviceName"
                                            class="form-select form-select-lg modern-select" required>
                                            <option value="">Choose a service...</option>
                                            @foreach ($meta as $service)
                                                <option value="{{ $service->uniqueId }}"
                                                    {{ old('serviceName') == $service->uniqueId ? 'selected' : '' }}>
                                                    {{ $service->serviceHeading }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <i class="bi bi-chevron-down select-icon"></i>
                                    </div>
                                    <div class="form-text">Select the service you want to create SEO meta for</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="domain" class="form-label fw-semibold">
                                        <i class="bi bi-globe me-1"></i>Select Domain
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="select-wrapper">
                                        <select name="domain" id="domain"
                                            class="form-select form-select-lg modern-select" required>
                                            <option value="">Choose a domain...</option>
                                            <option value="1" {{ old('domain') == '1' ? 'selected' : '' }}>
                                                <i class="bi bi-globe"></i> myitronline.com
                                            </option>
                                            <option value="2" {{ old('domain') == '2' ? 'selected' : '' }}>
                                                <i class="bi bi-globe"></i> clarityefiling.com
                                            </option>
                                            <option value="3" {{ old('domain') == '3' ? 'selected' : '' }}>
                                                <i class="bi bi-globe"></i> taxa23.com
                                            </option>
                                            <option value="4" {{ old('domain') == '4' ? 'selected' : '' }}>
                                                <i class="bi bi-globe"></i> eitrfiling.com
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
                            <small class="text-muted">Configure SEO metadata for better search engine ranking</small>
                        </div>
                        <div class="card-body p-4">
                            <div class="alert alert-info border-0 mb-4">
                                <i class="bi bi-lightbulb me-2"></i>
                                <strong>SEO Tips:</strong> Use relevant keywords and write compelling descriptions to
                                improve your search engine ranking and click-through rates.
                            </div>

                            <div class="row g-4">
                                <div class="col-12">
                                    <label for="seo_title" class="form-label fw-semibold">
                                        <i class="bi bi-type-h1 me-1"></i>Meta Title
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="metaTitle" id="seo_title"
                                        class="form-control form-control-lg" placeholder="Enter compelling SEO title..."
                                        value="{{ old('metaTitle') }}" maxlength="60" required>
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
                                    <label for="seo_keywords" class="form-label fw-semibold">
                                        <i class="bi bi-tags me-1"></i>Meta Keywords
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="metaKeyword" id="seo_keywords"
                                        class="form-control form-control-lg" placeholder="keyword1, keyword2, keyword3..."
                                        value="{{ old('metaKeyword') }}" required>
                                    <div class="form-text">Separate keywords with commas. Focus on 5-10 relevant keywords
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="seo_description" class="form-label fw-semibold">
                                        <i class="bi bi-card-text me-1"></i>Meta Description
                                        <span class="text-danger">*</span>
                                    </label>
                                    <textarea name="metaDescription" id="seo_description" class="form-control" rows="4"
                                        placeholder="Write a compelling description that appears in search results..." maxlength="160" required>{{ old('metaDescription') }}</textarea>
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
                                    <label for="seo_tags" class="form-label fw-semibold">
                                        <i class="bi bi-hash me-1"></i>Content Tags
                                        <span class="text-danger">*</span>
                                    </label>
                                    <textarea name="tag" id="seo_tags" class="form-control" rows="3" placeholder="tag1, tag2, tag3..."
                                        required>{{ old('tag') }}</textarea>
                                    <div class="form-text">Add relevant tags for content categorization and internal
                                        organization</div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <button type="submit" class="btn btn-success btn-lg px-5 me-3">
                                        <i class="bi bi-check-circle-fill me-2"></i>Create SEO Meta
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script src="{{ asset('js/metacreate.js') }}"></script>
@endsection
