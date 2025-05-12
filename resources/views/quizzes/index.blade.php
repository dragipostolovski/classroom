@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="display-4">Quizzes for {{ $class->title }}</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('classes.quizzes.create', $class->id) }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Create New Quiz
            </a>
        </div>
    </div>

    <div class="row">
        @if($quizzes->count() > 0)
            @foreach($quizzes as $quiz)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $quiz->title }}</h5>
                            <p class="card-text text-muted">
                                <i class="fas fa-question-circle"></i> 
                                Questions: {{ $quiz->questions_count ?? 'N/A' }}
                            </p>
                        </div>
                        <div class="card-footer bg-transparent">
                            <a href="{{ route('classes.quizzes.show', [$class->id, $quiz->id]) }}" 
                               class="btn btn-outline-primary w-100">
                                View Quiz
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> No quizzes available yet. Create your first quiz!
                </div>
            </div>
        @endif
    </div>
</div>
@endsection