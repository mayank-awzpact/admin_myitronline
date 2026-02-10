
@extends('backend.app')

@section('content')
<div>
   


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
        <div class="card p-4">
            <form action="{{ route('/submit-quiz-result') }}" method="POST">
                @csrf

                <h5>Choose a Match</h5>
            @if($matches->isEmpty())
            <p>No matches scheduled for today.</p>
        @else
            <div class="match-cards">
                        <select name="match_name" class="form-control">
                <option value="">Select Match</option>
                @foreach($matches as $match)
                    <option value="{{ $match->rival }}">
                        {{ $match->rival }} - {{ date('M d', strtotime($match->match_date2)) }}, {{ $match->match_time }}
                    </option>
                @endforeach
            </select>

            </div>
        @endif

                <h5>Question 1</h5>
<p>Who will win the toss?</p>
<div class="form-check">
    <input class="form-check-input" type="radio" name="q1" value="Punjab Kings" required>
    <label class="form-check-label">Punjab Kings</label>
</div>
<div class="form-check">
    <input class="form-check-input" type="radio" name="q1" value="Mumbai Indians">
    <label class="form-check-label">Mumbai Indians</label>
</div>

<h5>Question 2</h5>
<p>Is a 50+ score expected from Shreyas Iyer or Rohit Sharma in this match?</p>
<div class="form-check">
    <input class="form-check-input" type="radio" name="q2" value="Yes" required>
    <label class="form-check-label">Yes</label>
</div>
<div class="form-check">
    <input class="form-check-input" type="radio" name="q2" value="No">
    <label class="form-check-label">No</label>
</div>

<h5>Question 3</h5>
<p>What will be the approximate final score posted by the team batting first in today's match?</p>
<div class="form-check">
    <input class="form-check-input" type="radio" name="q3" value="Below 150 runs" required>
    <label class="form-check-label">Below 150 runs</label>
</div>
<div class="form-check">
    <input class="form-check-input" type="radio" name="q3" value="150 - 169 runs">
    <label class="form-check-label">150 - 169 runs</label>
</div>
<div class="form-check">
    <input class="form-check-input" type="radio" name="q3" value="170 - 189 runs">
    <label class="form-check-label">170 - 189 runs</label>
</div>
<div class="form-check">
    <input class="form-check-input" type="radio" name="q3" value="190+ runs">
    <label class="form-check-label">190+ runs</label>
</div>

<h5>Question 4</h5>
<p>What will be the total number of fours and sixes smashed by both teams combined?</p>
<div class="form-check">
    <input class="form-check-input" type="radio" name="q4" value="0–20" required>
    <label class="form-check-label">0–20</label>
</div>
<div class="form-check">
    <input class="form-check-input" type="radio" name="q4" value="20–26">
    <label class="form-check-label">20–26</label>
</div>
<div class="form-check">
    <input class="form-check-input" type="radio" name="q4" value="26–30">
    <label class="form-check-label">26–30</label>
</div>
<div class="form-check">
    <input class="form-check-input" type="radio" name="q4" value="30+">
    <label class="form-check-label">30+</label>
</div>

<h5>Question 5</h5>
<p>By what approximate margin will today's match likely be won?</p>
<div class="form-check">
    <input class="form-check-input" type="radio" name="q5" value="Very Close: 1-10 runs OR 1-3 wickets difference" required>
    <label class="form-check-label">Very Close: 1-10 runs OR 1-3 wickets difference</label>
</div>
<div class="form-check">
    <input class="form-check-input" type="radio" name="q5" value="Moderate: 11-30 runs OR 4-5 wickets difference">
    <label class="form-check-label">Moderate: 11-30 runs OR 4-5 wickets difference</label>
</div>
<div class="form-check">
    <input class="form-check-input" type="radio" name="q5" value="Comfortable: 31-50 runs OR 6-7 wickets difference">
    <label class="form-check-label">Comfortable: 31-50 runs OR 6-7 wickets difference</label>
</div>
<div class="form-check">
    <input class="form-check-input" type="radio" name="q5" value="Dominant: 51+ runs OR 8+ wickets difference / Bowling the opponent out">
    <label class="form-check-label">Dominant: 51+ runs OR 8+ wickets difference / Bowling the opponent out</label>
</div>

<div class="mb-3 w-50">
    <label for="created_at" class="form-label">Select Date</label>
    <input type="date" name="created_at" id="created_at" class="form-control form-control-sm" required>
</div>

                
                

                <button type="submit" class="btn btn-primary mt-4">Submit Quiz</button>
            </form>
        </div>
    </section>
</div>
@endsection