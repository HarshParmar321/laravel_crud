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
        'title' => 'required',
        'description' => 'nullable',
        'due_date' => 'nullable|date',
        'is_completed' => 'nullable|boolean',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Create a new Task instance
    $task = new Task();
    $task->title = $request->title;
    $task->description = $request->description;
    $task->due_date = $request->due_date;
    $task->is_completed = $request->has('is_completed');

    // Handle image upload
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('tasks', 'public');
        $task->image = $imagePath;
    }

    $task->save();

    return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
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
    
    $task->title = $request->title;
    $task->description = $request->description;
    $task->due_date = $request->due_date;
    $task->is_completed = $request->has('is_completed');

    // If new image is uploaded, update it
    if ($request->hasFile('image')) {
        $task->image = $request->file('image')->store('tasks', 'public');
    }

    $task->save();

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
