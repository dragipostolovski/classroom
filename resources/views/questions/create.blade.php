@extends('layouts.app')

@section('content')
<h1>Create Question for {{ $quiz->title }}</h1>
<form action="{{ route('quizzes.questions.store', $quiz->id) }}" method="POST">
    @csrf
    <label for="title">Title:</label>
    <input type="text" name="title" id="title" required>
    <label for="description">Description:</label>
    <textarea name="description" id="description"></textarea>
    <label for="options">Options (JSON format):</label>
    <textarea name="options" id="options" required></textarea>
    <label for="correct_option">Correct Option:</label>
    <input type="text" name="correct_option" id="correct_option" required>
    <button type="submit">Create Question</button>
</form>
@endsection