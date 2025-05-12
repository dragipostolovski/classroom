@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card shadow-lg mb-4 border-0 rounded-lg">
        <div class="card-body p-4">
            <h1 class="display-4 mb-3 text-gradient">{{ $quiz->title }}</h1>
            <p class="lead text-muted">{{ $quiz->description }}</p>
            
            <div class="bg-light p-4 rounded-lg mt-4 border">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="h4 text-primary mb-2">
                            <i class="fas fa-graduation-cap me-2"></i>Class: 
                            <a href="{{ route('classes.show', $class->id) }}" class="text-decoration-none">
                                {{ $class->title }}
                            </a>
                        </h2>
                        <p class="mb-0 text-muted">{{ $class->description }}</p>
                    </div>
                    <a href="{{ route('classes.show', $class->id) }}" class="btn btn-outline-primary">
                        <i class="fas fa-external-link-alt me-1"></i> View Class
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-lg border-0 rounded-lg mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <h3 class="h5 mb-0 text-primary">
                        <i class="fas fa-question-circle me-2"></i>Test your knowledge
                    </h3>
                    <a href="{{route('quizzes.questions.index', ['quiz' => $quiz->id])}}" class="btn btn-outline-primary">
                        <i class="fas fa-external-link-alt me-1"></i> Take Quiz
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-lg border-0 rounded-lg mb-4">
                <div class="card-header bg-white py-3">
                    <h3 class="h5 mb-0 text-primary">
                        <i class="fas fa-users me-2"></i>Student Results
                    </h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Score</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($quiz->scores as $score)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $score->user->avatar }}" class="rounded-circle me-2" width="30">
                                                {{ $score->user->first_name }} {{ $score->user->last_name }}
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $score->result >= 70 ? 'success' : ($score->result >= 50 ? 'warning' : 'danger') }}">
                                                {{ $score->result }}%
                                            </span>
                                        </td>
                                        <td>{{ $score->created_at->format('d.m.Y h:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card shadow-lg border-0 rounded-lg mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <h3 class="h5 mb-0 text-primary">
                        <i class="fas fa-question-circle me-2"></i>Questions
                    </h3>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addQuestionModal">
                        <i class="fas fa-plus me-1"></i> Add Question
                    </button>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @foreach($quiz->questions as $question)
                            <div class="list-group-item list-group-item-action p-4 mb-2 rounded-lg hover-shadow">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-2 text-primary">{{ $question->title }}</h5>
                                    <span>Question {{ $loop->iteration }}</span>
                                </div>
                                <p class="mb-3 text-muted">{{ $question->description }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach(json_decode($question->options) as $index => $option)
                                            <span class="badge {{ $index + 1 == $question->correct_option ? 'bg-success' : 'bg-secondary' }} p-2">
                                                {{ $option }}
                                            </span>
                                        @endforeach
                                    </div>
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-outline-primary mr-2" data-bs-toggle="tooltip" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Question Modal -->
<div class="modal fade" id="addQuestionModal" tabindex="-1" aria-labelledby="addQuestionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <form action="{{ route('quizzes.questions.store', ['quiz' => $quiz->id]) }}" method="POST">
                @csrf
                <div class="modal-header bg-light">
                    <h5 class="modal-title text-primary" id="addQuestionModalLabel">
                        <i class="fas fa-question-circle me-2"></i>Add New Question
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
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
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Save Question
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection