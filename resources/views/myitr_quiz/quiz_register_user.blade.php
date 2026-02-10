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
            <h4><i class="fas fa-cogs"></i> Quiz register user List</h4>
           
        </div>
        
        <div class="card-body">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>mobile</th>
                        <th>email</th>
                        <th>Date</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach($quizregister as $index => $quiz)
                        <tr id="row-{{ $quiz->id }}">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $quiz->full_name }}</td>
                            <td>{{ $quiz->mobile_number }}</td>
                            <td>{{ $quiz->email }}</td>
                            <td>{{ \Carbon\Carbon::parse($quiz->created_at)->setTimezone('Asia/Kolkata')->format('d M Y, h:i A') }}</td>


                           
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