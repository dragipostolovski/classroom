@extends('layouts.app')

@section('content')
<h1>Lessons for {{ $class->title }}</h1>
<a href="{{ route('classes.lessons.create', $class->id) }}">Create Lesson</a>
<ul>
    @foreach($lessons as $lesson)
        <li>{{ $lesson->title }}</li>
    @endforeach
</ul>
@endsection