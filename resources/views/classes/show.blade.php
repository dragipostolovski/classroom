@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-4">{{ $class->title }}</h1>
            <p class="lead">{{ $class->description }}</p>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2 class="h5 mb-0">Lessons</h2>
                    <a href="{{ route('classes.lessons.create', ['class' => $class->id]) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Add Lesson
                    </a>
                </div>
                <ul class="list-group list-group-flush">
                    @foreach($class->lessons as $lesson)
                        <li class="list-group-item">
                            <i class="fas fa-book text-primary"></i>
                            {{ $lesson->title }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2 class="h5 mb-0">Assignments</h2>
                    <a href="{{ route('classes.assignments.create', ['class' => $class->id]) }}" class="btn btn-sm btn-success">
                        <i class="fas fa-plus"></i> Add Assignment
                    </a>
                </div>
                <ul class="list-group list-group-flush">
                    @foreach($class->assignments as $assignment)
                        <li class="list-group-item">
                            <i class="fas fa-tasks text-success"></i>
                            <a href="{{ route('classes.assignments.show', ['class' => $class->id, 'assignment' => $assignment->id]) }}" class="text-decoration-none text-dark">{{ $assignment->title }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2 class="h5 mb-0">Quizzes</h2>
                    <a href="{{ route('classes.quizzes.create', ['class' => $class->id]) }}" class="btn btn-sm btn-danger">
                        <i class="fas fa-plus"></i> Add Quiz
                    </a>
                </div>
                <ul class="list-group list-group-flush">
                    @foreach($class->quizzes as $quiz)
                        <li class="list-group-item">
                            <i class="fas fa-question-circle text-danger"></i>
                            <a href="{{ route('classes.quizzes.show', ['class' => $class->id, 'quiz' => $quiz->id]) }}" class="text-decoration-none text-dark">{{ $quiz->title }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection