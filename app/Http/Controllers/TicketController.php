<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $projectId = $request->get('project_id');
        return view('tickets.create', compact('projectId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:created,in_progress,qa,done',
        ]);
        $ticket = \App\Models\Ticket::create($validated);
        return redirect()->route('projects.show', $ticket->project_id)
            ->with('success', 'Ticket created successfully!');
    }

    public function show($id)
    {
        $ticket = \App\Models\Ticket::with('project')->findOrFail($id);
        return view('tickets.show', compact('ticket'));
    }

    public function edit($id)
    {
        $ticket = \App\Models\Ticket::findOrFail($id);
        return view('tickets.edit', compact('ticket'));
    }

    public function update(Request $request, $id)
    {
        $ticket = \App\Models\Ticket::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:created,in_progress,qa,done',
        ]);
        $ticket->update($validated);
        return redirect()->route('tickets.show', $ticket->id)
            ->with('success', 'Ticket updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function updateStatus(Request $request, $id) {
        $ticket = \App\Models\Ticket::findOrFail($id);
        $ticket->status = $request->status;
        $ticket->save();
        return response()->json(['success' => true]);
    }
}
