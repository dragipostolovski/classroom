<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Magniva Dashboard</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body class="bg-light min-vh-100">
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
            <div class="container">
                <a class="navbar-brand fs-4 fw-bold" href="{{ url('/') }}">Magniva</a>
                <div class="navbar-nav ms-auto">
                    <a class="nav-link" href="{{ route('workspaces.index') }}">Workspaces</a>
                    <a class="nav-link" href="{{ route('projects.index') }}">Projects</a>
                    @guest
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    @else
                        <span class="nav-item d-flex align-items-center">
                            <span class="me-2">{{ Auth::user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Logout</button>
                            </form>
                        </span>
                    @endguest
                </div>
            </div>
        </nav>
        <main class="container text-center mt-5">
            <h1 class="display-4 fw-bold mb-3">Welcome to Magniva!</h1>
            <p class="lead mb-5">Manage your workspaces, projects, and tickets with ease.</p>
            <div class="d-flex justify-content-center gap-3">
            @guest
                <a href="{{ route('login') }}" class="btn btn-primary">Get started</a>
            @else
                <a href="{{ route('workspaces.index') }}" class="btn btn-primary">Go to Workspaces</a>
                <a href="{{ route('projects.index') }}" class="btn btn-outline-primary">View Projects</a>
            @endguest
            </div>
        </main>
    </body>
</html>