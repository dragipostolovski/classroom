@extends('layouts.app')
@section('content')
<h1>Edit Ticket</h1>
<form method="POST" action="{{ route('tickets.update', $ticket->id) }}">
    @csrf
    @method('PUT')
    <input type="text" name="title" value="{{ $ticket->title }}" required>
    <textarea name="description">{{ $ticket->description }}</textarea>
    <button type="submit">Update</button>
</form>
@endsection