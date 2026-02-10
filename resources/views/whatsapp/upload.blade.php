@extends('backend.app')
@section('content')
<div class="container mt-5">
    <h3>WhatsApp Messages</h3>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('whatsapp.send') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="csv_file" class="form-label">Upload CSV File (First column = phone)</label>
            <input type="file" name="csv_file" id="csv_file" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="message" class="form-label">Message to Send</label>
            <textarea name="message" id="message" rows="4" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-success">Send WhatsApp Messages</button>
    </form>
</div>
    <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('message');
    </script>
@endsection



