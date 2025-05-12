@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card shadow-lg mb-4 border-0 rounded-lg">
        <div class="card-body p-4">
            <div class="bg-light p-4 rounded-lg mt-4 mb-4 border">
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

            <h1 class="display-4 mb-3 text-gradient">{{ $assignment->title }}</h1>
            <p class="lead text-muted">{{ $assignment->description }}</p>
        </div>
    </div>
</div>

@endsection