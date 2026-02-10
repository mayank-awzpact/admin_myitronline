@extends('backend.app')

@section('content')

<div class="container mt-1">
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5><i class="fas fa-edit"></i> Edit Guide</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('guides.update', $id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Category Selection -->
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Horizontal Category</label>
                        <select name="horizontal_category" class="form-select select2" required>
                            <option value="GST Guide" {{ $guide->horizontal_category == 'GST Guide' ? 'selected' : '' }}>GST Guide</option>
                            <option value="Business Resources" {{ $guide->horizontal_category == 'Business Resources' ? 'selected' : '' }}>Business Resources</option>
                            <option value="Guide article" {{ $guide->horizontal_category == 'Guide article' ? 'selected' : '' }}>Guide article</option>
                            <option value="ITR Resources" {{ $guide->horizontal_category == 'ITR Resources' ? 'selected' : '' }}>ITR Resources</option>
                            <option value="Resources & Guides" {{ $guide->horizontal_category == 'Resources & Guides' ? 'selected' : '' }}>Resources & Guides</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Vertical Category</label>
                        <select name="vertical_category" class="form-select select2" required>
                            <option value="{{ $guide->vertical_category }}" selected>{{ $guide->vertical_category }}</option>
                        </select>
                    </div>
                </div>

                <!-- Guide Details -->
                <div class="row g-3 mt-3">
                    <div class="col-md-6">
                        <label class="form-label">Guide Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ $guide->name }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Slug (URL Alias)</label>
                        <input type="text" name="slug" id="slug" class="form-control" value="{{ $guide->slug }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Guide Heading</label>
                        <input type="text" name="guide_heading" class="form-control" value="{{ $guide->guide_heading }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select select2" required>
                            <option value="1" {{ $guide->status == 1 ? 'selected' : '' }}>Published</option>
                            <option value="0" {{ $guide->status == 0 ? 'selected' : '' }}>Unpublished</option>
                            <option value="2" {{ $guide->status == 2 ? 'selected' : '' }}>Draft</option>
                        </select>
                    </div>
                </div>

                <!-- Images Upload -->
                <div class="row g-3 mt-3">
                    <div class="col-md-6">
                        <label class="form-label">Intro Image</label>
                        <input type="file" name="intro_image" class="form-control">
                        <img src="{{ asset('storage/' . $guide->intro_image) }}" class="mt-2" width="100">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Full Article Image</label>
                        <input type="file" name="full_article_image" class="form-control">
                        <img src="{{ asset('storage/' . $guide->full_article_image) }}" class="mt-2" width="100">
                    </div>
                </div>

                <!-- Description -->
                <div class="row mt-3">
                    <div class="col-md-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" required>{{ $guide->description }}</textarea>
                    </div>
                </div>

                <!-- Accordions -->
                <div class="accordion mt-4" id="accordionExample">

                    <!-- Service Section -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseService">
                                Service Section
                            </button>
                        </h2>
                        <div id="collapseService" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Service Description</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="serviceTableBody">
                                        @foreach(json_decode($guide->service_sections, true) as $service)
                                            <tr>
                                                <td><input type="text" name="service_sections_title[]" class="form-control" value="{{ $service['title'] }}"></td>
                                                <td><textarea name="service_sections_description[]" class="form-control">{{ $service['description'] }}</textarea></td>
                                                <td><button class="btn btn-danger remove-row" type="button">Remove</button></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <button id="addRowButtonguide" class="btn btn-primary" type="button">Add New Row</button>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Section -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFAQ">
                                FAQ Fields
                            </button>
                        </h2>
                        <div id="collapseFAQ" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Question</th>
                                            <th>Answer</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="faqTable">
                                        @foreach(json_decode($guide->faq_fields, true) as $faq)
                                            <tr>
                                                <td><input type="text" name="faq_question[]" class="form-control" value="{{ $faq['question'] }}"></td>
                                                <td><textarea name="faq_answer[]" class="form-control">{{ $faq['answer'] }}</textarea></td>
                                                <td><button class="btn btn-danger remove-faq-row" type="button">Remove</button></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <button id="addFAQButton" class="btn btn-primary" type="button">Add New FAQ</button>
                            </div>
                        </div>
                    </div>

                    <!-- SEO Section -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSEO">
                                Search Engine Optimization
                            </button>
                        </h2>
                        <div id="collapseSEO" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <label class="form-label">Meta Title</label>
                                <input type="text" name="meta_title" class="form-control" value="{{ $guide->meta_title }}" required>

                                <label class="form-label">Meta Description</label>
                                <textarea name="meta_description" class="form-control" required>{{ $guide->meta_description }}</textarea>
                            </div>
                        </div>
                    </div>

                </div> <!-- End Accordions -->

                <!-- Submit Buttons -->
                <div class="mt-4 d-flex justify-content-between">
                    <button type="submit" class="btn btn-success"><i class="fas fa-check-circle"></i> Update Guide</button>
                    <a href="{{ route('guides.index') }}" class="btn btn-secondary"><i class="fas fa-undo"></i> Cancel</a>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection
