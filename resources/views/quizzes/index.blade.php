@extends('layouts.app')

@section('content')
<h1>Quizzes for {{ $class->title }}</h1>
<a href="{{ route('classes.quizzes.create', $class->id) }}">Create Quiz</a>
<ul>
    @foreach($quizzes as $quiz)
        <li><a href="{{ route('classes.quizzes.show', [$class->id, $quiz->id]) }}">{{ $quiz->title }}</a></li>
    @endforeach
</ul>
@endsection