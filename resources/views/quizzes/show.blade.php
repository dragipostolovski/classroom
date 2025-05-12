@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h1 class="display-4 mb-3">{{ $quiz->title }}</h1>
            <p class="lead text-muted">{{ $quiz->description }}</p>
            
            <div class="bg-light p-3 rounded mt-3">
                <h2 class="h4 text-primary mb-2">Class: {{ $class->title }}</h2>
                <p class="mb-0">{{ $class->description }}</p>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h3 class="h5 mb-0">Questions</h3>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addQuestionModal">
                <i class="fas fa-plus me-1"></i> Add Question
            </button>
        </div>
        <div class="card-body">
            <div class="list-group">
                @foreach($quiz->questions as $question)
                    <div class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-2">{{ $question->title }}</h5>
                            <small class="text-muted">Question {{ $loop->iteration }}</small>
                        </div>
                        <p class="mb-2">{{ $question->description }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex flex-wrap gap-2">
                                @foreach(json_decode($question->options) as $index => $option)
                                    <span class="badge {{ $index + 1 == $question->correct_option ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $option }}
                                    </span>
                                @endforeach
                            </div>
                            <div class="btn-group">
                                <a href="#" class="btn btn-sm btn-outline-primary mr-2">Edit</a>
                                <a href="#" class="btn btn-sm btn-outline-danger">Delete</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Add Question Modal -->
<div class="modal fade" id="addQuestionModal" tabindex="-1" aria-labelledby="addQuestionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('quizzes.questions.store', ['quiz' => $quiz->id]) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addQuestionModalLabel">
                        <i class="fas fa-question-circle me-2"></i>Add New Question
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-4">
                        <label for="title" class="form-label fw-bold">Question Title</label>
                        <input type="text" class="form-control form-control-lg" id="title" name="title" 
                               placeholder="Enter question title" required>
                    </div>
                    <div class="mb-4">
                        <label for="description" class="form-label fw-bold">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"
                                  placeholder="Enter question description"></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="options" class="form-label fw-bold">Answer Options</label>
                        <textarea class="form-control" id="options" name="options" rows="4" 
                                  placeholder="Enter options separated by commas" required></textarea>
                        <div class="form-text">Example: Option 1, Option 2, Option 3, Option 4</div>
                    </div>
                    <div class="mb-3">
                        <label for="correct_option" class="form-label fw-bold">Correct Option Number</label>
                        <input type="number" class="form-control" id="correct_option" name="correct_option" 
                               min="1" placeholder="Enter the number of the correct option" required>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Save Question
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection