@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Workspace</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('workspaces.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Workspace Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
        </div>
        <!-- <div class="mb-3">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug') }}" required>
        </div> -->
        <div class="mb-3">
            <label for="workspace-code" class="form-label">Workscpace Code</label>
            <input type="text" class="form-control" id="workspace-code" name="code" required maxlength="6" pattern="[A-Z]{1,6}">
            <small class="form-text text-muted">Max 6 uppercase letters, no numbers or special characters.</small>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description (optional)</label>
            <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Create Workspace</button>
    </form>
</div>
@endsection