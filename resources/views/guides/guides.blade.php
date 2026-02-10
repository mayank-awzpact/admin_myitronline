@extends('backend.app')

@section('content')

<div class="container border p-3 rounded">
    <div class="container mt-1">
        <h2 class="mb-3"><i class="bi bi-gear"></i> Guides List</h2>

        <!-- Search Filter & Create Button -->
        <div class="row g-2 mb-3">
            <div class="col-md-6">
                <form method="GET" action="{{ route('guides.index') }}" class="d-flex">
                    <input type="text" name="search" class="form-control form-control-sm me-2" id="searchGuide"
                        placeholder="Search by Name" value="{{ request()->search }}">
                    <button type="submit" class="btn btn-sm btn-primary me-2">Search</button>
                    @if(request()->has('search') && !empty(request()->search))
                        <a href="{{ route('guides.index') }}" class="btn btn-sm btn-secondary">Reset</a>
                    @endif
                </form>
            </div>
            
            <div class="col-md-6 text-end">
                <a href="{{ route('guides.create') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-plus-circle"></i>
                </a>
            </div>
        </div>

        <!-- Guides Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover table-sm">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Created On</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($guides as $index => $guide)
                        <tr>
                            <td>{{ ($guides->currentPage() - 1) * $guides->perPage() + $index + 1 }}</td>
                            <td>{{ $guide->name }}</td>
                            <td>{{ $guide->created_at }}</td>
                            <td>
                                <a href="{{ route('guides.edit', Crypt::encryptString($guide->uniqueId)) }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('guides.destroy', Crypt::encryptString($guide->uniqueId)) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this guide?');">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No Guides Found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination with Previous & Next -->
        <nav>
            <ul class="pagination pagination-sm justify-content-center">
                @if ($guides->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $guides->previousPageUrl() }}">Previous</a></li>
                @endif

                @for ($i = max(1, $guides->currentPage() - 2); $i <= min($guides->lastPage(), $guides->currentPage() + 2); $i++)
                    <li class="page-item {{ $guides->currentPage() == $i ? 'active' : '' }}">
                        <a class="page-link" href="{{ $guides->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor

                @if ($guides->hasMorePages())
                    <li class="page-item"><a class="page-link" href="{{ $guides->nextPageUrl() }}">Next</a></li>
                @else
                    <li class="page-item disabled"><span class="page-link">Next</span></li>
                @endif
            </ul>
        </nav>
    </div>

</div>

@endsection
