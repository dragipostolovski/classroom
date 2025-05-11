<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\ClassModel;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function index($classId)
    {
        $class = ClassModel::findOrFail($classId);
        $lessons = $class->lessons;
        return view('lessons.index', compact('class', 'lessons'));
    }

    public function create($classId)
    {
        $class = ClassModel::findOrFail($classId);
        return view('lessons.create', compact('class'));
    }

    public function store(Request $request, $classId)
    {
        $class = ClassModel::findOrFail($classId);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'nullable|date',
        ]);
        $class->lessons()->create($validated);
        return redirect()->route('classes.lessons.index', $classId)->with('success', 'Lesson created successfully!');
    }

    public function edit($classId, $id)
    {
        $class = ClassModel::findOrFail($classId);
        $lesson = $class->lessons()->findOrFail($id);
        return view('lessons.edit', compact('class', 'lesson'));
    }

    public function update(Request $request, $classId, $id)
    {
        $class = ClassModel::findOrFail($classId);
        $lesson = $class->lessons()->findOrFail($id);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'nullable|date',
        ]);
        $lesson->update($validated);
        return redirect()->route('classes.lessons.index', $classId)->with('success', 'Lesson updated successfully!');
    }

    public function destroy($classId, $id)
    {
        $class = ClassModel::findOrFail($classId);
        $lesson = $class->lessons()->findOrFail($id);
        $lesson->delete();
        return redirect()->route('classes.lessons.index', $classId)->with('success', 'Lesson deleted successfully!');
    }
}