@extends('layouts.app')

@section('content')
<h1>Create a New Lesson for {{ $class->title }}</h1>
<form action="{{ route('classes.lessons.store', $class->id) }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" class="form-control" id="title" name="title" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Create Lesson</button>
</form>
@endsection