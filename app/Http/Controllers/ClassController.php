<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        $classes = ClassModel::all();
        return view('classes.index', compact('classes'));
    }

    public function create()
    {
        return view('classes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        ClassModel::create($validated);
        return redirect()->route('classes.index')->with('success', 'Class created successfully!');
    }

    public function edit($id)
    {
        $class = ClassModel::findOrFail($id);
        return view('classes.edit', compact('class'));
    }

    public function update(Request $request, $id)
    {
        $class = ClassModel::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $class->update($validated);
        return redirect()->route('classes.index')->with('success', 'Class updated successfully!');
    }

    public function destroy($id)
    {
        $class = ClassModel::findOrFail($id);
        $class->delete();
        return redirect()->route('classes.index')->with('success', 'Class deleted successfully!');
    }

    public function show($id)
    {
        $class = ClassModel::with(['lessons', 'assignments', 'quizzes'])->findOrFail($id);
        return view('classes.show', compact('class'));
    }
}