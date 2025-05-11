@extends('layouts.app')

@section('content')
<h1>{{ $class->title }}</h1>
<p>{{ $class->description }}</p>

<h2>Lessons</h2>
<ul>
    @foreach($class->lessons as $lesson)
        <li style="color: blue;">{{ $lesson->title }}</li>
    @endforeach
</ul>

<h2>Assignments</h2>
<ul>
    @foreach($class->assignments as $assignment)
        <li style="color: green;">{{ $assignment->title }}</li>
    @endforeach
</ul>

<h2>Quizzes</h2>
<ul>
    @foreach($class->quizzes as $quiz)
        <li style="color: red;">{{ $quiz->title }}</li>
    @endforeach
</ul>
@endsection