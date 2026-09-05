@extends('backend.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-light border-0 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-calendar-plus me-2 text-primary"></i>Create Event
                    </h5>
                    <a href="{{ route('events.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i>Back to List
                    </a>
                </div>
            </div>

            <div class="card-body">
                <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @include('events._form', ['event' => null, 'media' => []])
                </form>
            </div>
        </div>
    </div>

    @include('events._form_scripts')
@endsection
