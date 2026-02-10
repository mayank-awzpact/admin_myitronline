@extends('backend.app')

@section('content')

<section class="container mt-4">
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4><i class="fas fa-cogs"></i> IPL 2025 match List</h4>
           
        </div>
        
        <div class="card-body">
            <form action="{{ route('ipl-match-update', ['id' => $match->id]) }}" method="POST">
 

    @csrf
    <div class="mb-3">
        <label>Match Number</label>
        <input type="text" name="match_number" value="{{ $match->match_number }}" class="form-control">
    </div>

    <div class="mb-3">
        <label>Match Date (e.g., Sun, May 25)</label>
        <input type="text" name="match_date" value="{{ $match->match_date }}" class="form-control">
    </div>

    <div class="mb-3">
        <label>Match Date2 (e.g., 2025-05-25)</label>
        <input type="date" name="match_date2" value="{{ $match->match_date2 }}" class="form-control">
    </div>

    <div class="mb-3">
        <label>Location</label>
        <input type="text" name="location" value="{{ $match->location }}" class="form-control">
    </div>

    <div class="mb-3">
        <label>Rival</label>
        <input type="text" name="rival" value="{{ $match->rival }}" class="form-control">
    </div>

    <div class="mb-3">
        <label>Match Time</label>
        <input type="text" name="match_time" value="{{ $match->match_time }}" class="form-control">
    </div>

    <button type="submit" class="btn btn-success">Update</button>
</form>

    </div>
</section>
@endsection