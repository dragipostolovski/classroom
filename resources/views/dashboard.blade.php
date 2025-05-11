@extends('layouts.app')

@section('content')

<h1>Dashboard</h1>
<p>Welcome, {{ Auth::user()->name }}! You have successfully registered and logged in.</p>
<a href="{{ route('workspaces.index') }}" class="btn btn-primary">Go to Workspaces</a>

@endsection