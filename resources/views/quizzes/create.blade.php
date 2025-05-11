@extends('layouts.app')

@section('content')
<h1>Create Quiz for {{ $class->title }}</h1>
<form action="{{ route('classes.quizzes.store', $class->id) }}" method="POST">
    @csrf
    <label for="title">Title:</label>
    <input type="text" name="title" id="title" required>
    <label for="description">Description:</label>
    <textarea name="description" id="description"></textarea>
    <button type="submit">Create Quiz</button>
</form>
@endsection