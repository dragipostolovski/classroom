@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h1 class="h3 mb-0">Create New Workspace</h1>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 shadow-sm">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('workspaces.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold">Workspace Name</label>
                            <input type="text" class="form-control form-control-lg" id="name" name="name" value="{{ old('name') }}" required placeholder="Enter workspace name">
                        </div>
                        <!-- <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug') }}" required>
                        </div> -->
                        <div class="mb-4">
                            <label for="workspace-code" class="form-label fw-bold">Workspace Code</label>
                            <input type="text" class="form-control form-control-lg" id="workspace-code" name="code" required maxlength="6" pattern="[A-Z]{1,6}" placeholder="ABCDEF">
                            <small class="form-text text-muted">Max 6 uppercase letters, no numbers or special characters.</small>
                        </div>
                        <div class="mb-4">
                            <label for="description" class="form-label fw-bold">Description <span class="text-muted">(optional)</span></label>
                            <textarea class="form-control form-control-lg" id="description" name="description" rows="4" placeholder="Enter workspace description">{{ old('description') }}</textarea>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-plus-circle me-2"></i>Create Workspace
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection