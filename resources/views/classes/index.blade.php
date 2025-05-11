@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Classes</h1>
        <a href="{{ route('classes.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-200">
            <i class="fas fa-plus mr-2"></i>Create Class
        </a>
    </div>

    @if($classes->isEmpty())
        <p class="text-gray-500 text-center py-8">No classes available.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($classes as $class)
                <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition duration-200">
                    <a href="{{ route('classes.show', $class->id) }}" class="block p-4">
                        <h2 class="text-xl font-semibold text-gray-800 hover:text-blue-500">
                            {{ $class->title }}
                        </h2>
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection