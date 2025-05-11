@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="display-4 mb-4">Projects by Workspace</h1>
    @if($workspaces->isEmpty())
        <div class="alert alert-info shadow-sm">No workspaces found.</div>
    @else
        @foreach($workspaces as $workspace)
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <div>
                        <strong>
                            <a href="{{ route('workspaces.show', $workspace->id) }}" class="text-decoration-none">
                                {{ $workspace->name }}
                            </a>
                        </strong>
                        <span class="badge bg-secondary ms-2">{{ $workspace->projects->count() }} projects</span>
                    </div>
                    <a href="{{ route('workspaces.show', $workspace->id) }}" class="btn btn-info btn-sm">
                        <i class="bi bi-eye"></i> View Workspace
                    </a>
                </div>
                <div class="card-body">
                    @if($workspace->projects->isEmpty())
                        <div class="alert alert-secondary mb-0">No projects in this workspace.</div>
                    @else
                        <ul class="list-group list-group-flush">
                            @foreach($workspace->projects as $project)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="{{ route('projects.show', $project->id) }}" class="text-decoration-none">
                                        {{ $project->name }}
                                    </a>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <form action="{{ route('projects.destroy', $project->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm ms-1" 
                                                onclick="return confirm('Are you sure you want to delete this project?')">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection