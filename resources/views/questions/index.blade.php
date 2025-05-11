@extends('layouts.app')

@section('content')
<h1>Questions for {{ $quiz->title }}</h1>
<a href="{{ route('quizzes.questions.create', $quiz->id) }}">Create Question</a>
<ul>
    @foreach($questions as $question)
        <li>{{ $question->title }}</li>
    @endforeach
</ul>
@endsection