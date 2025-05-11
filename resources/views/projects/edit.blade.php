@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Project</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('projects.update', $project->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Project Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $project->name) }}" required>
        </div>
        <div class="mb-3">
            <label for="project-code" class="form-label">Project Code</label>
            <input type="text" class="form-control" id="project-code" name="code" value="{{ old('name', $project->code) }}" required maxlength="6" pattern="[A-Z]{1,6}">
            <small class="form-text text-muted">Max 6 uppercase letters, no numbers or special characters.</small>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description (optional)</label>
            <textarea class="form-control" id="description" name="description">{{ old('description', $project->description) }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update Project</button>
        <a href="{{ route('projects.show', $project->id) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection