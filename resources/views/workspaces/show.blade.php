@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h1 class="card-title display-5 mb-4">{{ $workspace->name }}</h1>
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="border-start border-4 border-primary ps-3">
                        <p class="text-muted mb-1">Slug</p>
                        <p class="h5">{{ $workspace->slug }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="border-start border-4 border-success ps-3">
                        <p class="text-muted mb-1">Code</p>
                        <p class="h5">{{ $workspace->code }}</p>
                    </div>
                </div>
                <div class="col-12">
                    <div class="border-start border-4 border-info ps-3">
                        <p class="text-muted mb-1">Description</p>
                        <p class="h5">{{ $workspace->description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h3 class="h4 mb-0">Projects</h3>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addProjectModal">
                <i class="bi bi-plus-lg"></i> Add Project
            </button>
        </div>
        <div class="card-body">
            @if($workspace->projects->isEmpty())
                <div class="alert alert-info">No projects in this workspace.</div>
            @else
                <div class="list-group">
                    @foreach($workspace->projects as $project)
                        <a href="{{ route('projects.show', $project->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            {{ $project->name }}
                            <span class="badge bg-primary rounded-pill">View</span>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Add Project Modal -->
    <div class="modal fade" id="addProjectModal" tabindex="-1" aria-labelledby="addProjectModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('projects.store') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addProjectModalLabel">Add Project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="workspace_id" value="{{ $workspace->id }}">
                    <div class="mb-3">
                        <label for="project-name" class="form-label">Project Name</label>
                        <input type="text" class="form-control" id="project-name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="project-code" class="form-label">Project Code</label>
                        <input type="text" class="form-control" id="project-code" name="code" required maxlength="6" pattern="[A-Z]{1,6}">
                        <small class="form-text text-muted">Max 6 uppercase letters, no numbers or special characters.</small>
                    </div>
                    <div class="mb-3">
                        <label for="project-description" class="form-label">Description</label>
                        <textarea class="form-control" id="project-description" name="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Project</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white">
                    <h3 class="h4 mb-0">Users</h3>
                </div>
                <div class="card-body">
                    @if($workspace->users->isEmpty())
                        <div class="alert alert-info">No users assigned to this workspace.</div>
                    @else
                        <div class="list-group">
                            @foreach($workspace->users as $user)
                                <div class="list-group-item">
                                    <i class="bi bi-person-circle me-2"></i>{{ $user->email }}
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white">
                    <h3 class="h4 mb-0">Assign User</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('workspaces.assignUser', $workspace->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">User Email</label>
                            <div class="input-group">
                                <input type="email" name="email" id="email" class="form-control" required placeholder="Enter user email">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Assign User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show position-fixed bottom-0 end-0 m-3" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@endsection