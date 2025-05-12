@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col">
            <h1 class="display-4">Questions for {{ $quiz->title }}</h1>
        </div>
        <div class="col-auto">
            <a href="{{ route('quizzes.questions.create', $quiz->id) }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Create Question
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if($questions->count() > 0)
                <div class="list-group">
                    @foreach($questions as $question)
                        <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span>{{ $question->title }}</span>
                            <div class="btn-group">
                                <a href="#" class="btn btn-sm btn-outline-primary">Edit</a>
                                <a href="#" class="btn btn-sm btn-outline-danger">Delete</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center text-muted">
                    <p>No questions added yet.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection