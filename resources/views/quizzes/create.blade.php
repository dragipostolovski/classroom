@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h1 class="h3 mb-0">Create Quiz for {{ $class->title }}</h1>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 shadow-sm">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('classes.quizzes.store', $class->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="title">Title:</label>
                            <input class="form-control" type="text" name="title" id="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="description">Description:</label>
                            <textarea class="form-control" name="description" id="description"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Create Quiz</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection