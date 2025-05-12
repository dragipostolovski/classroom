@extends('layouts.app')

@section('content')
<h1>Create Question for {{ $quiz->title }}</h1>
<form action="{{ route('quizzes.questions.store', $quiz->id) }}" method="POST">
    @csrf
    <div class="modal-body">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description"></textarea>
        </div>
        <div class="mb-3">
            <label for="options" class="form-label">Options (comma-separated)</label>
            <textarea class="form-control" id="options" name="options" required></textarea>
        </div>
        <div class="mb-3">
            <label for="correct_option" class="form-label">Correct Option (number)</label>
            <input type="number" class="form-control" id="correct_option" name="correct_option" required>
        </div>
    </div>
    
    <button type="submit" class="btn btn-primary">Add Question</button>
</form>
@endsection