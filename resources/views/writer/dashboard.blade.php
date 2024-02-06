{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("writer : You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           Manager  Dashboard
        </h2>
    </x-slot>

    <div class="flex">
        <!-- Left Sidebar -->
        <div style="width: 200px; background-color: #333; padding: 20px; color: white;">
            <ul style="list-style-type: none; padding: 0;">
                <li><a href="{{ route('manager.home.dashboard') }}" style="text-decoration: none; color: white;">Home</a></li>
                <li><a href="{{ route('manager.tasks') }}" style="text-decoration: none; color: white;">Tasks</a></li>
                <!-- Add more links as needed -->

            </ul>
        </div>

        <!-- Main Content -->
        <div class="flex-1">
            <!-- Your main content goes here -->
            <div class="p-6">
                <!-- Content of the dashboard -->


                @if (request()->routeIs('manager.home.dashboard'))

                <div class="flex justify-between">
                    <div style="width: 150px; height: 100px; padding: 15px; margin: 10px; box-sizing: border-box; background-color: #ff6961; /* Tomato Red */; border: 2px solid transparent; transition: border-color 0.3s ease-in-out;" onmouseover="this.style.borderColor='#333'" onmouseout="this.style.borderColor='transparent'">
                        <h3 style="color: #fff; /* White */">Todo</h3>
                        <p style="color: #fff;">{{ $todoCount }} tasks</p>
                    </div>
                    <div style="width: 200px; height: 100px; padding: 15px; margin: 10px; box-sizing: border-box; background-color: #ffd700; /* Gold */; border: 2px solid transparent; transition: border-color 0.3s ease-in-out;" onmouseover="this.style.borderColor='#333'" onmouseout="this.style.borderColor='transparent'">
                        <h3 style="color: #333; /* Dark Gray */">In Progress</h3>
                        <p style="color: #333;">{{ $inProgressCount }} tasks</p>
                    </div>
                    <div style="width: 150px; height: 100px; padding: 15px; margin: 10px; box-sizing: border-box; background-color: #2ecc71; /* Emerald Green */; border: 2px solid transparent; transition: border-color 0.3s ease-in-out;" onmouseover="this.style.borderColor='#333'" onmouseout="this.style.borderColor='transparent'">
                        <h3 style="color: #fff; /* White */">Done</h3>
                        <p style="color: #fff;">{{ $doneCount }} tasks</p>
                    </div>
                </div>

                @endif

                <!-- Add the following code for Tasks form -->
                @if (request()->routeIs('manager.tasks'))
                <div class="row">
                    <div class="col-md-12">
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible">{{ session('status') }}</div>
                        @endif

                        <div class="card">
                            <div class="card-header">
                                <h4>Tasks</h4>
                                <a href="{{ route('manager.tasks.create') }}" class="btn btn-primary float-end">Create</a>
                            </div>
                            <div class="card-body">
                                @if ($tasks->isEmpty())
                                    <div class="alert alert-danger text-center">No tasks available</div>
                                @else
                                    <table class="col-12 table table-striped table-bordered">
                                        <tr>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach ($tasks as $task)
                                            <tr>
                                                <td class="col-3">{{ $task->title }}</td>
                                                <td class="col-4">{{ $task->description }}</td>
                                                <td class="col-2">{{ $task->status }}</td>
                                                <td class="col-3">
                                                    <a href="{{ route('manager.tasks.edit', ['id' => $task->id]) }}" class="btn btn-primary">Edit</a>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>

                                    {{ $tasks->links() }} <!-- Display pagination links -->
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if (request()->routeIs('manager.tasks.edit'))
                <div class="container">
                    <h2>Edit Task</h2>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('manager.tasks.update', ['id' => $task->id]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" name="title" value="{{ $task->title }}">
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" name="description">{{ $task->description }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" name="status">
                                <option value="To Do" {{ $task->status == 'To Do' ? 'selected' : '' }}>To Do</option>
                                <option value="In Progress" {{ $task->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="Completed" {{ $task->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Task</button>
                    </form>
                </div>
                @endif

                @if (request()->routeIs('manager.tasks.create'))
                <div class="card">
                    <div class="card-header">

                    </div>
                    <div class="card-body">
                        <form action="{{ route('manager.tasks.store') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" class="form-control" cols="20" rows="5">{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" class="form-control">
                                    <option value="To Do" {{ old('status') == 'To Do' ? 'selected' : '' }}>To Do</option>
                                    <option value="In Progress" {{ old('status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="Completed" {{ old('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                                @error('status')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group float-end mt-3">
                                <input type="submit" name="submit" class="btn btn-success">
                            </div>
                        </form>

                    </div>
                </div>
                @endif





            </div>
        </div>
    </div>




    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var successMessage = "{{ session('success') }}";

            if (successMessage) {
                alert(successMessage);
            }
        });
    </script>

    {{-- <script>
    function deleteTask(taskId) {
        var confirmation = confirm("Are you sure you want to delete this task?");

        if (confirmation) {
            window.location.href = "{{ url('manager/tasks/delete') }}/" + taskId;
        } else {
            // If the user cancels, do nothing
        }
    }
</script> --}}


</x-app-layout>
