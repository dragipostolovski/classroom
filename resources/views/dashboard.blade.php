@extends('layouts.app')

@section('content')

<div class="hero bg-primary text-white py-5 mb-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="display-4 fw-bold">Welcome Back, {{ Auth::user()->name }}!</h1>
                <p class="lead">You've successfully logged into your dashboard. Ready to get started?</p>
            </div>
            <div class="col-md-4 text-md-end">
                <i class="fas fa-user-circle fa-3x"></i>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto text-center">
            <div class="card shadow-sm">
                <div class="card-body p-5">
                    <h2 class="card-title mb-4">Your Workspace Hub</h2>
                    <p class="card-text mb-4">Access and manage all your workspaces from one central location.</p>
                    <a href="{{ route('workspaces.index') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-rocket me-2"></i>Go to Workspaces
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection