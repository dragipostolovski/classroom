<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Workspace;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $workspaces = Workspace::with('projects')->get();
        return view('projects.index', compact('workspaces'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'workspace_id' => 'required|exists:workspaces,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|regex:/^[A-Z]{1,6}$/|unique:projects,code',
            'description' => 'nullable|string',
        ]);
        Project::create($validated);
        return redirect()->route('workspaces.show', $request->workspace_id)
            ->with('success', 'Project added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $project = Project::with(['workspace.users', 'users', 'tickets'])->findOrFail($id);
        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $project = \App\Models\Project::findOrFail($id);
        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $project = \App\Models\Project::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|regex:/^[A-Z]{1,6}$/|unique:projects,code,' . $project->id,
            'description' => 'nullable|string',
        ]);
        $project->update($validated);
        return redirect()->route('projects.show', $project->id)
            ->with('success', 'Project updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $project = Project::findOrFail($id);
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Project deleted successfully!');
    }

    public function assignUser(Request $request, $id)
    {
        $request->validate(['user_id' => 'required|exists:users,id']);
        $project = Project::with('workspace.users')->findOrFail($id);

        // Only allow assignment if user is in the workspace
        $workspaceUserIds = $project->workspace->users->pluck('id')->toArray();
        if (!in_array($request->user_id, $workspaceUserIds)) {
            return redirect()->route('projects.show', $project->id)
                ->with('user_success', 'User is not assigned to the workspace.');
        }

        $project->users()->syncWithoutDetaching([$request->user_id]);

        return redirect()->route('projects.show', $project->id)
            ->with('user_success', 'User assigned to project!');
    }
}
