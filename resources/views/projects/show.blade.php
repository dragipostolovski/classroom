@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h1 class="display-5 mb-4">{{ $project->name }}</h1>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="card bg-light">
                        <div class="card-body">
                            <p class="mb-2"><i class="bi bi-link"></i> <strong>Slug:</strong> {{ $project->slug }}</p>
                            <p class="mb-2"><i class="bi bi-file-text"></i> <strong>Description:</strong> {{ $project->description }}</p>
                            <p class="mb-2"><i class="bi bi-code-square"></i> <strong>Code:</strong> {{ $project->code }}</p>
                            <p class="mb-0"><i class="bi bi-briefcase"></i> <strong>Workspace:</strong>
                                <a href="{{ route('workspaces.show', $project->workspace_id) }}" class="text-decoration-none">
                                    {{ $project->workspace->name }}
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Edit Project
                        </a>
                        <form action="{{ route('projects.destroy', $project->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this project?')">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                        <a href="{{ route('projects.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0">Tickets</h2>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addTicketModal">
            <i class="bi bi-plus-lg"></i> Add Ticket
        </button>
    </div>

    <!-- Add Ticket Modal -->
    <div class="modal fade" id="addTicketModal" tabindex="-1" aria-labelledby="addTicketModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('tickets.store') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addTicketModalLabel">Add Ticket</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                    <div class="mb-3">
                        <label for="ticket-title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="ticket-title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="ticket-description" class="form-label">Description</label>
                        <textarea class="form-control" id="ticket-description" name="description" rows="3"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="ticket-priority" class="form-label">Priority</label>
                                <select class="form-select" id="ticket-priority" name="priority" required>
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="ticket-status" class="form-label">Status</label>
                                <select class="form-select" id="ticket-status" name="status" required>
                                    <option value="created">Created</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="qa">QA</option>
                                    <option value="done">Done</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Ticket</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-4" id="kanban-board">
        @php
            $statuses = [
                'created' => 'Created',
                'in_progress' => 'In Progress',
                'qa' => 'QA',
                'done' => 'Done'
            ];
            $priorityColors = [
                'low' => 'secondary',
                'medium' => 'warning',
                'high' => 'danger'
            ];
        @endphp
        @foreach($statuses as $statusKey => $statusLabel)
            <div class="col-md-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-header bg-light">
                        <h6 class="text-center mb-0">{{ $statusLabel }}</h6>
                    </div>
                    <ul class="list-group list-group-flush kanban-column" id="column-{{ $statusKey }}" data-status="{{ $statusKey }}" style="min-height: 200px;">
                        @foreach($project->tickets->where('status', $statusKey) as $ticket)
                            <li class="list-group-item ticket-item p-3" data-ticket-id="{{ $ticket->id }}">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span class="badge bg-{{ $priorityColors[$ticket->priority] ?? 'secondary' }}">
                                        {{ ucfirst($ticket->priority) }}
                                    </span>
                                    <small class="text-muted">ID: #{{ $ticket->id }}</small>
                                </div>
                                <h6 class="mb-2">{{ $ticket->title }}</h6>
                                <p class="mb-0 text-muted small">{{ $ticket->description }}</p>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row mt-5">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h3 class="h5 mb-0">Assigned Users</h3>
                </div>
                <div class="card-body">
                    @if($project->users->isEmpty())
                        <div class="alert alert-info mb-0">No users assigned to this project.</div>
                    @else
                        <ul class="list-group list-group-flush">
                            @foreach($project->users as $user)
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="bi bi-person-circle me-2"></i>
                                    {{ $user->email }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h3 class="h5 mb-0">Assign User</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('projects.assignUser', $project->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Select User</label>
                            <select name="user_id" id="user_id" class="form-select" required>
                                <option value="">-- Select User --</option>
                                @foreach($project->workspace->users as $user)
                                    <option value="{{ $user->id }}">{{ $user->email }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-person-plus"></i> Assign User
                        </button>
                    </form>
                    @if(session('user_success'))
                        <div class="alert alert-success mt-3">{{ session('user_success') }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SortableJS CDN -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const statuses = ['created', 'in_progress', 'qa', 'done'];
    statuses.forEach(function(status) {
        new Sortable(document.getElementById('column-' + status), {
            group: 'kanban',
            animation: 150,
            onAdd: function (evt) {
                const ticketId = evt.item.getAttribute('data-ticket-id');
                const newStatus = evt.to.getAttribute('data-status');
                fetch('/tickets/' + ticketId + '/update-status', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({status: newStatus})
                }).then(response => response.json())
                  .then(data => {
                      // Optionally show a success message or handle errors
                  });
            }
        });
    });
});
</script>
@endsection