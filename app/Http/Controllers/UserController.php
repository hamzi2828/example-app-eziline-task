<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Import DB facade from correct namespace


use App\Models\User;

class UserController extends Controller
{

public function index()
{
    // Paginate users along with their task counts
    $users = User::select('users.id', 'users.name', 'users.email', 'users.is_active', 'users.user_type', DB::raw('COUNT(tasks.id) as task_count'))
        ->leftJoin('tasks', 'users.id', '=', 'tasks.user_id')
        ->groupBy('users.id', 'users.name', 'users.email', 'users.is_active', 'users.user_type') // Group by additional user columns
        ->paginate(4); // Specify the number of users per page

    return view('admin.dashboard', compact('users'));
}

public function edit($id)
{
    // dd($id);
    $user = User::findOrFail($id);
    return view('admin.dashboard', compact('user'));
}
public function update(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $request->id,
        'is_active' => 'boolean',
        'user_type' => 'in:admin,manager,user',
        // Add validation for other fields as needed
    ]);

    $user = User::find($request->id);

    if (!$user) {
        // Handle case where the user is not found
        return redirect()->route('users')->back()->with('error', 'User not found');
    }

    $is_active = $request->has('is_active') ? true : false;

    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'is_active' => $is_active,
        'user_type' => $request->user_type,
        // Update other fields as needed
    ]);


    //  dd($is_active); // Add this line to your controller update method

    // return redirect()->back()->with('success', 'User updated successfully');
    return redirect()->route('users')->with('status', 'User updated successfully');

}


public function delete($id)
{
    // Find the user by ID
    $user = User::findOrFail($id);

    // Perform the delete action
    $user->delete();

    // Redirect back with a success message
    return redirect()->route('users')->with('status', 'User deleted successfully');
}

}
