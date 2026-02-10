@extends('backend.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm bg-gradient-primary text-white">
                    <div class="card-body py-4">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-1 fw-bold">
                                    <i class="bi bi-pencil-square-fill me-2"></i>
                                    Edit Service
                                </h3>
                                <p class="mb-0 opacity-75">Update your service information</p>
                            </div>
                            <div class="col-auto">
                                <div class="bg-white text-black bg-opacity-20 rounded-pill px-3 py-2">
                                    <i class="bi bi-gear-fill me-1"></i>
                                    <span class="fw-semibold">Service Editor</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <form action="{{ route('services.update', $id) }}" method="POST" id="serviceForm">
                    @csrf
                    @method('POST')

                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light border-0 py-3">
                            <h5 class="mb-0 fw-semibold">
                                <i class="bi bi-info-circle-fill text-primary me-2"></i>
                                Basic Information
                            </h5>
                            <small class="text-muted">Essential details about your service</small>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">
                                        <i class="bi bi-tag me-1"></i>Service Title <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="serviceName" id="name"
                                        class="form-control form-control-lg"
                                        value="{{ old('serviceName', $service->serviceName ?? '') }}"
                                        placeholder="Enter service title..." required onkeyup="generateSlug()">
                                    <div class="form-text">This will be the main title displayed to customers</div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">
                                        <i class="bi bi-link-45deg me-1"></i>Permalink
                                    </label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-light text-muted">
                                            <i class="bi bi-globe me-1"></i> https://www.myitronline.com/
                                        </span>
                                        <input type="text" name="serviceAlias" id="slug" class="form-control"
                                            value="{{ old('serviceAlias', $service->serviceAlias ?? '') }}"
                                            placeholder="service-url" required>
                                    </div>
                                    <div class="form-text">URL-friendly version of your service title</div>
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-semibold">
                                        <i class="bi bi-type-h1 me-1"></i>Service Heading <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="serviceHeading" class="form-control form-control-lg"
                                        value="{{ old('serviceHeading', $service->serviceHeading ?? '') }}"
                                        placeholder="Enter compelling service heading..." required>
                                    <div class="form-text">A catchy headline that grabs attention</div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light border-0 py-3">
                            <h5 class="mb-0 fw-semibold">
                                <i class="bi bi-file-text-fill text-success me-2"></i>
                                Service Description
                            </h5>
                            <small class="text-muted">Detailed information about your service</small>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">
                                <div class="col-12">
                                    <label class="form-label fw-semibold"><i class="bi bi-card-text me-1"></i>Short
                                        Description</label>
                                    <textarea name="serviceSynopsis" class="form-control" rows="3"
                                        placeholder="Brief overview of your service (optional)...">{{ old('serviceSynopsis', $service->serviceSynopsis ?? '') }}</textarea>
                                    <div class="form-text">A brief summary that appears in service listings</div>
                                </div>

                                {{-- <div class="col-12">
                                    <label class="form-label fw-semibold">
                                        <i class="bi bi-journal-text me-1"></i>Full Description <span
                                            class="text-danger">*</span>
                                    </label>
                                    <div class="textarea-wrapper">
                                        <div class="editor-toolbar">
                                            <button type="button" class="toolbar-btn" data-action="bold" title="Bold">
                                                <i class="bi bi-type-bold" style="font-size:0.8rem;"></i>
                                            </button>
                                            <button type="button" class="toolbar-btn" data-action="italic" title="Italic">
                                                <i class="bi bi-type-italic" style="font-size:0.8rem;"></i>
                                            </button>
                                            <button type="button" class="toolbar-btn" data-action="underline"
                                                title="Underline">
                                                <i class="bi bi-type-underline" style="font-size:0.8rem;"></i>
                                            </button>
                                            <div class="toolbar-divider"></div>
                                            <button type="button" class="toolbar-btn" data-action="list"
                                                title="Bullet List">
                                                <i class="bi bi-list-ul" style="font-size:0.8rem;"></i>
                                            </button>
                                            <button type="button" class="toolbar-btn" data-action="link"
                                                title="Insert Link">
                                                <i class="bi bi-link" style="font-size:0.8rem;"></i>
                                            </button>
                                        </div>
                                        <textarea name="serviceDescription" id="description" class="form-textarea" rows="6"
                                            placeholder="Compose your email message here..." required>{{ old('serviceDescription', $service->serviceDescription ?? '') }}</textarea>
                                        <div class="textarea-focus-border"></div>
                                    </div>
                                    <div class="form-text">Complete details about features, benefits, and what's included
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light border-0 py-3">
                            <h5 class="mb-0 fw-semibold">
                                <i class="bi bi-currency-dollar text-warning me-2"></i>
                                Pricing & Settings
                            </h5>
                            <small class="text-muted">Configure pricing and publication settings</small>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">
                                        <i class="bi bi-tag-fill me-1"></i>Service Price <span
                                            class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-light"><i
                                                class="bi bi-currency-dollar"></i></span>
                                        <input type="number" name="servicePrice" class="form-control"
                                            value="{{ old('servicePrice', $service->servicePrice ?? '') }}"
                                            placeholder="0.00" step="0.01" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold"><i class="bi bi-receipt me-1"></i>Tax/GST
                                        Percentage</label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-light"><i class="bi bi-percent"></i></span>
                                        <input type="number" name="gst" class="form-control"
                                            value="{{ old('gst', $service->gst ?? '') }}" placeholder="0" min="0"
                                            max="100" step="0.01">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold"><i class="bi bi-percent me-1"></i>Price
                                        Discount</label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-light"><i class="bi bi-percent"></i></span>
                                        <input type="number" name="priceDiscount" class="form-control"
                                            value="{{ old('priceDiscount', $service->priceDiscount ?? '') }}"
                                            placeholder="0" min="0" max="100">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold"><i class="bi bi-eye-fill me-1"></i>Publish
                                        Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-select form-select-lg" required>
                                        <option value="">Choose status...</option>
                                        <option value="1" {{ ($service->status ?? '') == 1 ? 'selected' : '' }}>
                                            Published</option>
                                        <option value="0" {{ ($service->status ?? '') == 0 ? 'selected' : '' }}>
                                            Unpublished</option>
                                        <option value="2" {{ ($service->status ?? '') == 2 ? 'selected' : '' }}>Draft
                                        </option>
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label for="offer_dates" class="form-label fw-semibold"><i
                                            class="bi bi-calendar-range me-1"></i>Offer Dates</label>
                                    <div class="date-picker-wrapper">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text bg-light"><i
                                                    class="bi bi-calendar-event text-primary"></i></span>
                                            <input type="text" name="Offer_date" id="offer_dates"
                                                class="form-control date-input"
                                                value="{{ old('Offer_date', $service->Offer_date ?? '') }}"
                                                autocomplete="off" placeholder="Click to select offer period..." readonly>
                                            <button class="btn btn-outline-secondary" type="button"
                                                id="clearOfferDates">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </div>
                                        <div class="form-text">
                                            <i class="bi bi-info-circle me-1"></i>
                                            Set special offer dates for this service (optional).
                                            <span class="text-muted">Selected:
                                                <span id="selectedDatesText" class="fw-medium">
                                                    @if ($service->Offer_date ?? '')
                                                        <strong class="text-success">{{ $service->Offer_date }}</strong>
                                                    @else
                                                        None
                                                    @endif
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @php
                        $secTitleCombined = old('secTitle', $service->secTitle ?? '');
                        $secSTitleCombined = old('secSTitle', $service->secSTitle ?? '');
                        $secDescCombined = old('secDescrption', $service->secDescrption ?? '');

                        $tArr = array_map('trim', explode('```', (string) $secTitleCombined));
                        $sArr = array_map('trim', explode('```', (string) $secSTitleCombined));
                        $dArr = array_map('trim', explode('```', (string) $secDescCombined));

                        $tArr = array_values(array_filter($tArr, fn($v) => $v !== '' || $v === '0'));
                        $sArr = array_values(array_filter($sArr, fn($v) => $v !== '' || $v === '0'));
                        $dArr = array_values(array_filter($dArr, fn($v) => $v !== '' || $v === '0'));

                        $maxRows = max(count($tArr), count($sArr), count($dArr), 1);
                        for ($i = 0; $i < $maxRows; $i++) {
                            if (!isset($tArr[$i])) {
                                $tArr[$i] = '';
                            }
                            if (!isset($sArr[$i])) {
                                $sArr[$i] = '';
                            }
                            if (!isset($dArr[$i])) {
                                $dArr[$i] = '';
                            }
                        }
                    @endphp

                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light border-0 py-3" style="cursor:pointer;" data-bs-toggle="collapse"
                            data-bs-target="#serviceSectionCollapse" aria-expanded="false"
                            aria-controls="serviceSectionCollapse">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-0 fw-semibold">
                                        <i class="bi bi-journal-richtext text-primary me-2"></i> Service Section
                                    </h5>
                                    <small class="text-muted">Add section title, subtitle, and description</small>
                                </div>
                                <i class="bi bi-chevron-down transition fs-5"></i>
                            </div>
                        </div>

                        <div id="serviceSectionCollapse" class="collapse">
                            <div class="card-body p-4">
                                <div class="table-responsive">
                                    <table class="table table-borderless">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width: 28%;" class="fw-semibold"><i
                                                        class="bi bi-type-h1 me-1"></i>Section Title</th>
                                                <th style="width: 28%;" class="fw-semibold"><i
                                                        class="bi bi-type-h2 me-1"></i>Section Subtitle</th>
                                                <th style="width: 34%;" class="fw-semibold"><i
                                                        class="bi bi-card-text me-1"></i>Description (HTML)</th>
                                                <th style="width: 10%;" class="fw-semibold text-center"><i
                                                        class="bi bi-gear me-1"></i>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="serviceSectionBody">
                                            @for ($i = 0; $i < $maxRows; $i++)
                                                <tr class="service-row">
                                                    <td>
                                                        <input type="text" class="form-control" name="secTitle_rows[]"
                                                            placeholder="An Overview of One Person Company (OPC)"
                                                            value="{{ $tArr[$i] }}">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="secSTitle_rows[]"
                                                            placeholder="Introduction / Benefits / Documentation / Package offers / Guide"
                                                            value="{{ $sArr[$i] }}">
                                                    </td>
                                                    <td>
                                                        <textarea class="form-control" rows="3" name="secDescrption_rows[]"
                                                            placeholder="<p>HTML block for this row...</p>">{{ $dArr[$i] }}</textarea>
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button"
                                                            class="btn btn-outline-danger btn-sm remove-service-row"
                                                            data-bs-toggle="tooltip" title="Remove row">
                                                            <i class="bi bi-trash3"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endfor
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-center mt-3">
                                    <button type="button" class="btn btn-outline-primary" id="addServiceRow">
                                        <i class="bi bi-plus-circle me-2"></i>Add Another Row
                                    </button>
                                </div>

                                <input type="hidden" id="secTitleHidden" name="secTitle"
                                    value="{{ $secTitleCombined }}">
                                <input type="hidden" id="secSTitleHidden" name="secSTitle"
                                    value="{{ $secSTitleCombined }}">
                                <input type="hidden" id="secDescrptionHidden" name="secDescrption"
                                    value="{{ $secDescCombined }}">
                                <div class="form-text mt-2">Values are stored using the separator <code>```</code>.</div>
                            </div>
                        </div>
                    </div>

                    @php
                        $faqTitles = $service->serFaqTitle ? explode('```', $service->serFaqTitle) : [];
                        $faqContents = $service->serFaqContent ? explode('```', $service->serFaqContent) : [];
                    @endphp
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light border-0 py-3" style="cursor:pointer;" data-bs-toggle="collapse"
                            data-bs-target="#faqCollapse" aria-expanded="false" aria-controls="faqCollapse">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-0 fw-semibold">
                                        <i class="bi bi-question-circle-fill text-info me-2"></i> Frequently Asked
                                        Questions
                                    </h5>
                                    <small class="text-muted">Add common questions and answers</small>
                                </div>
                                <i class="bi bi-chevron-down transition fs-5" id="faqToggleIcon"></i>
                            </div>
                        </div>
                        <div id="faqCollapse" class="collapse">
                            <div class="card-body p-4">
                                <div class="table-responsive">
                                    <table class="table table-borderless">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width: 40%;" class="fw-semibold"><i
                                                        class="bi bi-question-circle me-1"></i>Question</th>
                                                <th style="width: 45%;" class="fw-semibold"><i
                                                        class="bi bi-chat-square-text me-1"></i>Answer</th>
                                                <th style="width: 15%;" class="fw-semibold text-center"><i
                                                        class="bi bi-gear me-1"></i>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="faqTableBody">
                                            @if (count($faqTitles) > 0)
                                                @foreach ($faqTitles as $index => $question)
                                                    @if (trim($question))
                                                        <tr class="faq-row">
                                                            <td><input type="text" name="faq_titles[]"
                                                                    class="form-control" value="{{ trim($question) }}"
                                                                    placeholder="Enter your question..."></td>
                                                            <td>
                                                                <textarea name="faq_contents[]" class="form-control" rows="2" placeholder="Provide a detailed answer...">{{ trim($faqContents[$index] ?? '') }}</textarea>
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="button"
                                                                    class="btn btn-outline-danger btn-sm remove-faq"
                                                                    data-bs-toggle="tooltip" title="Remove FAQ">
                                                                    <i class="bi bi-trash3"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @else
                                                <tr class="faq-row">
                                                    <td><input type="text" name="faq_titles[]" class="form-control"
                                                            placeholder="What is included in this service?"></td>
                                                    <td>
                                                        <textarea name="faq_contents[]" class="form-control" rows="2" placeholder="Provide a detailed answer..."></textarea>
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button"
                                                            class="btn btn-outline-danger btn-sm remove-faq"
                                                            data-bs-toggle="tooltip" title="Remove FAQ">
                                                            <i class="bi bi-trash3"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-center mt-3">
                                    <button type="button" class="btn btn-outline-primary" id="addNewFaq">
                                        <i class="bi bi-plus-circle me-2"></i>Add Another FAQ
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light border-0 py-3">
                            <button class="btn btn-link text-decoration-none p-0 w-100 text-start" type="button"
                                data-bs-toggle="collapse" data-bs-target="#collapseSEO" aria-expanded="false"
                                aria-controls="collapseSEO">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="mb-0 fw-semibold text-dark">
                                            <i class="bi bi-search text-primary me-2"></i> Search Engine Optimization
                                        </h5>
                                        <small class="text-muted">Improve your service's visibility in search
                                            results</small>
                                    </div>
                                    <i class="bi bi-chevron-down fs-5 text-muted"></i>
                                </div>
                            </button>
                        </div>

                        <div id="collapseSEO" class="collapse">
                            <div class="card-body p-4">
                                <div class="alert alert-warning border-0 mb-4" role="alert">
                                    <i class="bi bi-lightbulb me-2"></i>
                                    <strong>SEO Tips:</strong>
                                    Keep Meta Title within 50–60 characters and Meta Description within 150–160 characters.
                                    Put key terms near the start and avoid duplicate snippets.
                                </div>

                                <div class="row g-4">
                                    <div class="col-12">
                                        <label for="seo_title" class="form-label fw-semibold"><i
                                                class="bi bi-type-h1 me-1"></i>Meta Title</label>
                                        <input type="text" name="metaTitle" id="seo_title"
                                            class="form-control form-control-lg"
                                            value="{{ old('metaTitle', $service->metaTitle ?? '') }}"
                                            placeholder="SEO-friendly title for search engines..." maxlength="70">
                                        <div id="seo_title_hint" class="form-text">Recommended: 50–60 characters</div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="seo_keywords" class="form-label fw-semibold"><i
                                                class="bi bi-tags me-1"></i>Meta Keywords</label>
                                        <input type="text" name="metaKeyword" id="seo_keywords" class="form-control"
                                            value="{{ old('metaKeyword', $service->metaKeyword ?? '') }}"
                                            placeholder="keyword1, keyword2, keyword3...">
                                        <div class="form-text">Separate keywords with commas</div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="seo_tags" class="form-label fw-semibold"><i
                                                class="bi bi-hash me-1"></i>Tags</label>
                                        <input type="text" name="tag" id="seo_tags" class="form-control"
                                            value="{{ old('tag', $service->tag ?? '') }}"
                                            placeholder="tag1, tag2, tag3...">
                                        <div class="form-text">Content tags for categorization</div>
                                    </div>

                                    <div class="col-12">
                                        <label for="seo_description" class="form-label fw-semibold"><i
                                                class="bi bi-card-text me-1"></i>Meta Description</label>
                                        <textarea name="metaDescription" id="seo_description" class="form-control" rows="3"
                                            placeholder="Brief description that appears in search results..." maxlength="200">{{ old('metaDescription', $service->metaDescription ?? '') }}</textarea>
                                        <div id="seo_desc_hint" class="form-text">Recommended: 150–160 characters</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <button type="submit" class="btn btn-success btn-lg px-5">
                                <i class="bi bi-check-circle-fill me-2"></i>Update Service
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/services.js') }}"></script>
@endsection
