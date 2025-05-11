@extends('layouts.app')
@section('content')
<form method="POST" action="{{ route('profile.update') }}" class="max-w-md mx-auto p-6 bg-white rounded-lg shadow-md">
    @csrf
    @method('PUT')
    
    <div class="mb-4">
        <label for="first_name" class="block text-gray-700 text-sm font-bold mb-2">First Name</label>
        <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $user->first_name) }}" 
            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    <div class="mb-4">
        <label for="last_name" class="block text-gray-700 text-sm font-bold mb-2">Last Name</label>
        <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}"
            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    <div class="mb-4">
        <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
        <textarea id="description" name="description" 
            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 h-32">{{ old('description', $user->description) }}</textarea>
    </div>

    <div class="mb-4">
        <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    <div class="mb-6">
        <label for="linked_url" class="block text-gray-700 text-sm font-bold mb-2">Linked URL</label>
        <input type="url" id="linked_url" name="linked_url" value="{{ old('linked_url', $user->linked_url) }}"
            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    <button type="submit" class="btn btn-success">
        Update Profile
    </button>
</form>
@endsection