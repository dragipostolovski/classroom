@extends('layouts.app')
@section('content')
<h1>{{ $ticket->title }}</h1>
<p>{{ $ticket->description }}</p>
<a href="{{ route('tickets.edit', $ticket->id) }}">Edit</a>
<form method="POST" action="{{ route('tickets.destroy', $ticket->id) }}">
    @csrf
    @method('DELETE')
    <button type="submit">Delete</button>
</form>
@endsection
@endsection