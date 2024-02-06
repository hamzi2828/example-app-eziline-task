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
           User  Dashboard
        </h2>
    </x-slot>

    <div class="flex">
        <!-- Left Sidebar -->
        <div style="width: 200px; background-color: #333; padding: 20px; color: white;">
            <ul style="list-style-type: none; padding: 0;">
                <li><a href="{{ route('home.dashboard') }}" style="text-decoration: none; color: white;">Home</a></li>
                <li><a href="{{ route('user.tasks.show') }}" style="text-decoration: none; color: white;">Tasks</a></li>
                <!-- Add more links as needed -->

            </ul>
        </div>

        <!-- Main Content -->
        <div class="flex-1">
            <!-- Your main content goes here -->
            <div class="p-6">
                <!-- Content of the dashboard -->


                @if (request()->routeIs('home.dashboard'))

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
                 @if (request()->routeIs('user.tasks.show'))
                 <h2 style="text-align: center; color: #d14b4b; font-weight: bold;">Your Tasks</h2>

                 <!-- Task List Container -->
                 <div style="display: flex; flex-wrap: wrap; gap: 20px;">
                     @foreach($tasks as $task)
                         <a href="{{ route('user.tasks.edit', ['id' => $task->id]) }}" style="text-decoration: none; color: inherit;">
                             <div style="border: 1px solid {{ $task->status !== 'To Do' ? '#e74c3c' : '#ddd' }}; padding: 10px; width: 400px; background-color: #fff; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); cursor: pointer;">
                                 <!-- Stylish Title -->
                                 <h3 style="color: #3498db; text-align: center; font-size: 1.5em; margin-bottom: 10px;">
                                     {{ $task->title }}
                                 </h3>

                                 <!-- Styled Description -->
                                 <p style="color: #555; text-align: center; font-size: 1.2em; margin-bottom: 15px;">
                                     {{ $task->description }}
                                 </p>

                                 <!-- Status with Badge -->
                                 <p style="margin-bottom: 5px; text-align: center;">
                                     Status:
                                     <span style="padding: 5px; border-radius: 5px; color: #fff;
                                         @if($task->status == 'To Do') background-color: #e74c3c; /* Red color for 'To Do' */
                                         @elseif($task->status == 'In Progress') background-color: #f39c12; /* Yellow color for 'In Progress' */
                                         @else background-color: #2ecc71; /* Green color for 'Completed' */
                                         @endif">
                                         {{ $task->status }}
                                     </span>
                                 </p>
                             </div>
                         </a>
                     @endforeach
                 </div>
                             <!-- Pagination Links -->
                             {{ $tasks->links() }}
             @endif




             @if (request()->routeIs('user.tasks.edit'))
             <div class="container">
                 <h2>Edit Task</h2>

                 @if (session('status'))
                     <div class="alert alert-success">{{ session('status') }}</div>
                 @endif

                 <form action="{{ route('user.tasks.update', ['id' => $task->id]) }}" method="POST">
                     @csrf
                     @method('PUT')

                     <div class="form-group">
                         <label for="title">Title</label>
                         <input type="text" class="form-control" name="title" value="{{ $task->title }}" readonly>
                     </div>

                     <div class="form-group">
                         <label for="description">Description</label>
                         <textarea class="form-control" name="description" readonly>{{ $task->description }}</textarea>
                     </div>

                     <div class="form-group">
                         <label for="status">Status</label>
                         <select class="form-control" name="status">
                             <option value="To Do" {{ $task->status == 'To Do' ? 'selected' : '' }}>To Do</option>
                             <option value="In Progress" {{ $task->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                             <option value="Completed" {{ $task->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                         </select>
                     </div>

                     <button type="submit" class="btn btn-primary">Update Status</button>
                 </form>
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

    <script>


</x-app-layout>
