@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2">Classes</h1>
        <a href="{{ route('classes.create') }}" class="btn btn-primary">Create Class</a>
    </div>

    @if($classes->isEmpty())
        <p class="text-muted text-center py-4">No classes available.</p>
    @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($classes as $class)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <a href="{{ route('classes.show', $class->id) }}" class="text-decoration-none">
                                <h2 class="card-title h5 text-dark">
                                    {{ $class->title }}
                                </h2>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection