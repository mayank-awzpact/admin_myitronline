@extends('backend.app')

@section('content')

<div class="container mt-1">
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5><i class="fas fa-plus-circle"></i> Create Guide</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('guides.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Category Selection -->
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Horizontal Category</label>
                        <select name="horizontal_category" class="form-select select2" required>
                            <option value="" disabled selected>-- Select Category --</option>
                            <option value="GST Guide">GST Guide</option>
                            <option value="Business Resources">Business Resources</option>
                            <option value="Guide article">Guide article</option>
                            <option value="ITR Resources">ITR Resources</option>
                            <option value="Resources & Guides">Resources & Guides</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Vertical Category</label>
                        <select name="vertical_category" class="form-select select2" required>
                            <option value="" disabled selected>-- Select Category --</option>
                            <option value="Vertical Category">Vertical Category</option>
                        </select>
                    </div>
                </div>

                <!-- Guide Details -->
                <div class="row g-3 mt-3">
                    <div class="col-md-6">
                        <label class="form-label">Guide Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Guide Name" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Slug (URL Alias)</label>
                        <input type="text" name="slug" id="slug" class="form-control" placeholder="Slug" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Guide Heading</label>
                        <input type="text" name="guide_heading" class="form-control" placeholder="Guide Heading" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select select2" required>
                            <option value="1">Published</option>
                            <option value="0">Unpublished</option>
                            <option value="2">Draft</option>
                        </select>
                    </div>
                </div>

                <!-- Images Upload -->
                <div class="row g-3 mt-3">
                    <div class="col-md-6">
                        <label class="form-label">Intro Image</label>
                        <input type="file" name="intro_image" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Full Article Image</label>
                        <input type="file" name="full_article_image" class="form-control" required>
                    </div>
                </div>

                <!-- Description -->
                <div class="row mt-3">
                    <div class="col-md-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" placeholder="Guide Description" required></textarea>
                    </div>
                </div>

                <!-- Accordion Sections -->
                <div class="accordion mt-4" id="accordionExample">
                    <!-- Service Section -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseService">
                                Service Section
                            </button>
                        </h2>
                        <div id="collapseService" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
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
                                        <tr>
                                            <td><input type="text" name="service_sections_title[]" class="form-control" placeholder="Title"></td>
                                            <td><textarea name="service_sections_description[]" class="form-control" placeholder="Service Description"></textarea></td>
                                            <td><button class="btn btn-danger remove-row" type="button">Remove</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <button id="addRowButtonguide" class="btn btn-primary" type="button">Add New Row</button>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Section -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFAQ">
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
                                        <tr>
                                            <td><input type="text" name="faq_question[]" class="form-control" placeholder="Enter Question"></td>
                                            <td><textarea name="faq_answer[]" class="form-control" placeholder="Enter Answer"></textarea></td>
                                            <td><button class="btn btn-danger remove-faq-row" type="button">Remove</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <button id="addFAQButton" class="btn btn-primary" type="button">Add New FAQ</button>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSEO">
                                Search Engine Optimization
                            </button>
                        </h2>
                        <div id="collapseSEO" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label">Meta Title</label>
                                        <input type="text" name="meta_title" class="form-control" placeholder="Meta Title" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Robots</label>
                                        <select name="robots" class="form-select select2" required>
                                            <option value="Use Global">Use Global</option>
                                            <option value="index, follow">index, follow</option>
                                            <option value="noindex, follow">noindex, follow</option>
                                            <option value="index, nofollow">index, nofollow</option>
                                            <option value="noindex, nofollow">noindex, nofollow</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Meta Keyword</label>
                                        <input type="text" name="meta_keyword" class="form-control" placeholder="Meta Keyword" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Tags</label>
                                        <input type="text" name="tags" class="form-control" placeholder="Tags" required>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <label class="form-label">Meta Description</label>
                                        <textarea name="meta_description" class="form-control" placeholder="Meta Description" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="mt-4 d-flex justify-content-between">
                    <button type="submit" class="btn btn-success"><i class="fas fa-check-circle"></i> Create</button>
                    <a href="{{ route('guides.index') }}" class="btn btn-secondary"><i class="fas fa-undo"></i> Cancel</a>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection
