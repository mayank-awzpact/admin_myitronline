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
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Match Name</th>
                        <th>Match Number</th>
                        <th>Match Date</th>
                        <th>Match Location</th>
                        <th>Action</th>
                      
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach($ipl_matches_2025 as $index => $quiz)
                        <tr id="row-{{ $quiz->id }}">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $quiz->rival }}</td>
                            <td>{{ $quiz->match_number }}</td>
                            <td>{{ $quiz->match_date2 }}</td>
                            <td>{{ $quiz->location }}</td>
                          <td>
                            <a href="{{ route('ipl-match-edit', ['id' => $quiz->id]) }}" class="btn btn-sm btn-primary">Edit</a>

                            </td>


                           
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <nav>
            <ul class="pagination justify-content-center">
                <li class="page-item disabled"><a class="page-link">Previous</a></li>
                <li class="page-item active"><a class="page-link">1</a></li>
                <li class="page-item disabled"><a class="page-link">Next</a></li>
            </ul>
        </nav>
    </div>
</section>
@endsection