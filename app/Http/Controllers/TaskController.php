<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\task;

class TaskController extends Controller
{
    public function index()
{

    $tasks = Task::paginate(3);  // Retrieve all tasks from the database

    return view('admin.dashboard', compact('tasks'));

}


public function create ()
{


    return view('admin.dashboard');
}

public function store(Request $request)
{
    $request->validate([
        'title' => 'required|max:255',
        'description' => 'required',
        'status' => 'required|in:To Do,In Progress,Completed',
        // Add other validation rules as needed
    ]);

    // dd($request->all());


    Task::create([
        'title' => $request->title,
        'description' => $request->description,
        'status' => $request->status,
        // Add other fields as needed
    ]);

    return redirect()->route('admin.tasks')->with('status', 'Task created successfully');
}

public function edit($id)
{
    // dd($id);
    $task = task::findOrFail($id);
    return view('admin.dashboard', compact('task'));
}



public function update(Request $request, $id)
{
    // ... (existing code)
    $task = task::find($request->id);

    $request->validate([
        'title' => 'required|max:255',
        'description' => 'required',
        'status' => 'required|in:To Do,In Progress,Completed',
    ]);

    $task->update([
        'title' => $request->title,
        'description' => $request->description,
        'status' => $request->status,
    ]);

    return redirect()->route('admin.tasks')->with('status', 'Task updated successfully');

}


public function delete($id)
{
    // Find the task by ID
    $task = Task::findOrFail($id);

    // Perform the delete action
    $task->delete();

    // Redirect back with a success message
    return redirect()->route('admin.tasks')->with('status', 'Task deleted successfully');
}

public function dashboard()
{

    $todoCount = Task::where('status', 'To Do')->count();
    $inProgressCount = Task::where('status', 'In Progress')->count();
    $doneCount = Task::where('status', 'Completed')->count();

    // dd( $todoCount);
    return view('admin.dashboard', compact('todoCount', 'inProgressCount', 'doneCount'));
}


}
