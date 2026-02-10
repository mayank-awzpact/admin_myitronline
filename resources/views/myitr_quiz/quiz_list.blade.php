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
            <h4><i class="fas fa-cogs"></i> Answers List</h4>
            <a href="{{ route('/add-quiz-result') }}">
                <button class="btn btn-success"><i class="bi bi-plus-circle-fill"></i> Add Result</button>
            </a>
        </div>
        
        <div class="card-body">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Match Name</th>
                        <th>Q1</th>
                        <th>Q2</th>
                        <th>Q3</th>
                        <th>Q4</th>
                        <th>Q5</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($quizAnswers as $index => $quiz)
                        <tr id="row-{{ $quiz->id }}">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $quiz->match_name }}</td>
                            <td>{{ $quiz->q1 }}</td>
                            <td>{{ $quiz->q2 }}</td>
                            <td>{{ $quiz->q3 }}</td>
                            <td>{{ $quiz->q4 }}</td>
                            <td>{{ $quiz->q5 }}</td>
                            <td>{{ \Carbon\Carbon::parse($quiz->created_at)->setTimezone('Asia/Kolkata')->format('d M Y, h:i A') }}</td>


                            <td>
                                <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $quiz->id }}">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $(".delete-btn").click(function() {
            let id = $(this).data("id");

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('administrator/delete-quiz-result') }}/" + id,
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            $("#row-" + id).remove();
                            Swal.fire("Deleted!", "The record has been deleted.", "success");
                        },
                        error: function(xhr) {
                            Swal.fire("Error!", "Something went wrong.", "error");
                        }
                    });
                }
            });
        });
    });
</script>
@endsection