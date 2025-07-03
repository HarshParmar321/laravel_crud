<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the tasks.
     */
    public function index()
    {
        $tasks = Task::all();
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new task.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created task in storage.
     */
   public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'due_date' => 'nullable|date|before:2100-01-01',
        'is_completed' => 'nullable|boolean',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048', // Max 2MB
    ]);

    $data = $request->only(['title', 'description', 'due_date']);
    $data['is_completed'] = $request->has('is_completed');

    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('tasks', 'public');
    }

    Task::create($data);

    return redirect()->route('tasks.index')->with('success', 'Task created successfully!');
}




    /**
     * Display the specified task.
     */
    public function show($id)
    {
        $task = Task::findOrFail($id);
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified task.
     */
    public function edit($id)
    {
        $task = Task::findOrFail($id);
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified task in storage.
     */
    public function update(Request $request, $id)
{
    $request->validate([
        'title' => 'required',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
    ]);

    $task = Task::findOrFail($id);
    
    $data = $request->only(['title', 'description', 'due_date']);
    $data['is_completed'] = $request->has('is_completed');

    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('tasks', 'public');
    }

    $task->update($data);

    return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
}


    /**
     * Remove the specified task from storage.
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }
}
