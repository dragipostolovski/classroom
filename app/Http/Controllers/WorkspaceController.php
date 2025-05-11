<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Workspace;

class WorkspaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $workspaces = Workspace::with('users', 'projects')->get();
        // return view('workspaces.index', compact('workspaces'));

        // $workspaces = auth()->user()->workspaces()->with('users', 'projects')->get();
        // return view('workspaces.index', compact('workspaces'));

        if (!auth()->check()) {
            return redirect()->route('login');
        }
        $workspaces = auth()->user()->workspaces()->with('users', 'projects')->get();
        return view('workspaces.index', compact('workspaces'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('workspaces.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|regex:/^[A-Z]{1,6}$/|unique:workspaces,code',
            'description' => 'nullable|string',
        ]);
    
        $workspace = Workspace::create(array_merge($validated, [
            'created_by' => auth()->id(),
        ]));
    
        $workspace->users()->attach(auth()->id());
    
        return redirect()->route('workspaces.index')->with('success', 'Workspace created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $workspace = Workspace::with(['users', 'projects'])->findOrFail($id);
        return view('workspaces.show', compact('workspace'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $workspace = Workspace::findOrFail($id);
        return view('workspaces.edit', compact('workspace'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $workspace = Workspace::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            // 'slug' => 'required|string|max:255|unique:workspaces,slug,' . $workspace->id,
            'code' => 'required|string|regex:/^[A-Z]{1,6}$/|unique:workspaces,code',
            'description' => 'nullable|string',
        ]);

        $workspace->update($validated);

        return redirect()->route('workspaces.index')->with('success', 'Workspace updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $workspace = Workspace::findOrFail($id);
        $workspace->delete();

        return redirect()->route('workspaces.index')->with('success', 'Workspace deleted successfully!');
    }

     /**
     * Assign a user to the workspace by email.
     */
    public function assignUser(Request $request, string $id)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $workspace = Workspace::findOrFail($id);

        // Try to find the user by email, or create if not exists
        $user = \App\Models\User::firstOrCreate(
            ['email' => $request->email],
            ['name' => $request->email, 'password' => bcrypt('password')] // Default name and password
        );

        // Attach user to workspace if not already attached
        if (!$workspace->users->contains($user->id)) {
            $workspace->users()->attach($user->id);
        }

        return redirect()->route('workspaces.show', $workspace->id)
            ->with('success', 'User assigned to workspace!');
    }
}
