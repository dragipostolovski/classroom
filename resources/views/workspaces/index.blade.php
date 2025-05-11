@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Workspaces</h1>
    <a href="{{ route('workspaces.create') }}" class="btn btn-primary">Create Workspace</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($workspaces->isEmpty())
    <div class="alert alert-info">No workspaces found.</div>
@else
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Code</th>
                <th>Slug</th>
                <th>Description</th>
                <th>Projects</th>
                <th>Users</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($workspaces as $workspace)
                <tr>
                    <td>
                        <a href="{{ route('workspaces.show', $workspace->id) }}">
                            {{ $workspace->name }}
                        </a>
                    </td>
                    <td>{{ $workspace->code }}</td>
                    <td>{{ $workspace->slug }}</td>
                    <td>{{ $workspace->description }}</td>
                    <td>{{ $workspace->projects->count() }}</td>
                    <td>{{ $workspace->users->count() }}</td>
                    <td>
                        <a href="{{ route('workspaces.show', $workspace->id) }}" class="btn btn-sm btn-info">View</a>
                        <a href="{{ route('workspaces.edit', $workspace->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('workspaces.destroy', $workspace->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this workspace?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
@endsection