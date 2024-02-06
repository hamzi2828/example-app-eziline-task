<?php

namespace App\Http\Controllers;
use App\Models\task;
use Illuminate\Http\Request;

class ManagerTaskController extends Controller
{

public function dashboardManager()
{

    $todoCount = Task::where('status', 'To Do')->count();
    $inProgressCount = Task::where('status', 'In Progress')->count();
    $doneCount = Task::where('status', 'Completed')->count();

    // dd( $todoCount);
    return view('writer.dashboard', compact('todoCount', 'inProgressCount', 'doneCount'));
}

public function showmanagertasks()
{

    $tasks = Task::paginate(3);  // Retrieve all tasks from the database

    return view('writer.dashboard', compact('tasks'));

}

public function managercreatetask ()
{


    return view('writer.dashboard');
}

public function managerstoretask(Request $request)
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

    return redirect()->route('manager.tasks')->with('status', 'Task created successfully');
}
public function edit($id)
{
    // dd($id);
    $task = task::findOrFail($id);
    return view('writer.dashboard', compact('task'));
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

    return redirect()->route('manager.tasks')->with('status', 'Task updated successfully');

}
}
