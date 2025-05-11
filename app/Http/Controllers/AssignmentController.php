<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\ClassModel;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function index($classId)
    {
        $class = ClassModel::findOrFail($classId);
        $assignments = $class->assignments;
        return view('assignments.index', compact('class', 'assignments'));
    }

    public function create($classId)
    {
        $class = ClassModel::findOrFail($classId);
        return view('assignments.create', compact('class'));
    }

    public function store(Request $request, $classId)
    {
        $class = ClassModel::findOrFail($classId);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $class->assignments()->create($validated);
        return redirect()->route('classes.show', $classId)->with('success', 'Assignment created successfully!');
    }

    public function edit($classId, $id)
    {
        $class = ClassModel::findOrFail($classId);
        $assignment = $class->assignments()->findOrFail($id);
        return view('assignments.edit', compact('class', 'assignment'));
    }

    public function update(Request $request, $classId, $id)
    {
        $class = ClassModel::findOrFail($classId);
        $assignment = $class->assignments()->findOrFail($id);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $assignment->update($validated);
        return redirect()->route('classes.assignments.index', $classId)->with('success', 'Assignment updated successfully!');
    }

    public function destroy($classId, $id)
    {
        $class = ClassModel::findOrFail($classId);
        $assignment = $class->assignments()->findOrFail($id);
        $assignment->delete();
        return redirect()->route('classes.assignments.index', $classId)->with('success', 'Assignment deleted successfully!');
    }
}