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
            <h4><i class="fas fa-cogs"></i>User Quiz Answers List</h4>
          
        </div>
        
        <div class="card-body">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Match Name</th>
                        <th>User Name</th>
                        <th>User Email</th>
                        <th>Q1</th>
                        <th>Q2</th>
                        <th>Q3</th>
                        <th>Q4</th>
                        <th>Q5</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($quizsubmit as $index => $quiz)
                        <tr id="row-{{ $quiz->id }}">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $quiz->match_name }}</td>
                            <td>{{ $quiz->full_name }}</td>
                            <td>{{ $quiz->email }}</td>
                            <td>{{ $quiz->q1 }}</td>
                            <td>{{ $quiz->q2 }}</td>
                            <td>{{ $quiz->q3 }}</td>
                            <td>{{ $quiz->q4 }}</td>
                            <td>{{ $quiz->q5 }}</td>
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