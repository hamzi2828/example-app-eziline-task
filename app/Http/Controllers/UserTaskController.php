<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth;



class UserTaskController extends Controller
{
    //
    public function dashboardManager()
{

    $todoCount = Task::where('status', 'To Do')->count();
    $inProgressCount = Task::where('status', 'In Progress')->count();
    $doneCount = Task::where('status', 'Completed')->count();

    // dd( $todoCount);
    return view('dashboard', compact('todoCount', 'inProgressCount', 'doneCount'));
}


// TaskController.php

public function showusertask()
{
    $tasks = Task::paginate(4);
    return view('dashboard', compact('tasks'));
}

public function edit($id)
{
    // dd($id);
    $task = task::findOrFail($id);
    return view('dashboard', compact('task'));
}



public function update(Request $request, $id)
{
    $task = Task::findOrFail($id);

    $request->validate([
        'title' => 'required|max:255',
        'description' => 'required',
        'status' => 'required|in:To Do,In Progress,Completed',
    ]);

    $user_id = auth()->user()->id;

    // Check if the task is not in "To Do" status
    if ($task->status !== 'To Do' && $task->user_id !== $user_id) {
        return redirect()->route('user.tasks.show')->with('success', 'Task is already in progress or completed by another user.');
    }

    // Update the task with the provided data
    $task->update([
        'title' => $request->title,
        'description' => $request->description,
        'status' => $request->status,
        'user_id' => $user_id,
    ]);

    return redirect()->route('user.tasks.show')->with('success', 'Task updated successfully');
}


public function startTaskInProgress(Request $request, $id)
{
    $task = Task::findOrFail($id);

    // Check if the task is already in progress
    if ($task->status === 'In Progress' && $task->user_id !== Auth::id()) {
        return back()->with('error', 'This task is already in progress by another user.');
    }

    // Start the task and assign it to the current user
    $task->status = 'In Progress';
    $task->user_id = Auth::id();
    $task->started_at = now();
    $task->save();

    return back()->with('success', 'Task started successfully.');
}


}
