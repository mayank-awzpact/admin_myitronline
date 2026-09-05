@extends('backend.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-light border-0 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-pencil-square me-2 text-warning"></i>Edit Event
                        <small class="text-muted">— {{ $event->eventTitle }}</small>
                    </h5>
                    <a href="{{ route('events.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i>Back to List
                    </a>
                </div>
            </div>

            <div class="card-body">
                <form action="{{ route('events.update', $id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @include('events._form')
                </form>
            </div>
        </div>
    </div>

    @include('events._form_scripts')
@endsection
