<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserTaskController;
use App\Http\Controllers\ManagerTaskController;
use Illuminate\Console\View\Components\Task;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('home');

Route::middleware(['auth', 'admin'])->group(function () {
    // Admin-only routes here
Route::get('/home/dashboard', [TaskController::class, 'dashboard'])->name('admin.home.dashboard');
Route::get('/admin/tasks/show', [TaskController::class, 'index'])->name('admin.tasks');
Route::get('/admin/tasks/create', [TaskController::class, 'create'])->name('admin.tasks.create');
Route::post('/admin/tasks/store', [TaskController::class, 'store'])->name('admin.tasks.store');
Route::get('/admin/tasks/edit/{id}', [TaskController::class, 'edit'])->name('admin.tasks.edit');
Route::put('/admin/tasks/{id}', [TaskController::class, 'update'])->name('admin.tasks.update');
Route::get('/admin/tasks/delete/{id}', [TaskController::class, 'delete'])->name('admin.tasks.delete');

Route::get('/admin/users/show', [UserController::class, 'index'])->name('users');
Route::get('/admin/users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
Route::post('/admin/users/update', [UserController::class, 'update'])->name('update.users');
Route::get('/admin/users/delete/{id}', [UserController::class, 'delete'])->name('users.delete');
});

Route::middleware(['auth', 'manager'])->group(function () {

Route::get('/manager/dashboard', [ManagerTaskController::class, 'dashboardManager'])->name('manager.home.dashboard');
Route::get('/manager/tasks/show', [ManagerTaskController::class, 'showmanagertasks'])->name('manager.tasks');
Route::get('/manager/tasks/create', [ManagerTaskController::class, 'managercreatetask'])->name('manager.tasks.create');
Route::post('/manager/tasks/store', [ManagerTaskController::class, 'managerstoretask'])->name('manager.tasks.store');
Route::get('/manager/tasks/edit/{id}', [ManagerTaskController::class, 'edit'])->name('manager.tasks.edit');
Route::put('/manager/tasks/{id}', [ManagerTaskController::class, 'update'])->name('manager.tasks.update');

});

// web.php

Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/user/dashboard', [UserTaskController::class, 'dashboardManager'])->name('home.dashboard');
    Route::get('/user/tasks/show', [UserTaskController::class, 'showusertask'])->name('user.tasks.show');
    Route::get('/user/tasks/edit/{id}', [UserTaskController::class, 'edit'])->name('user.tasks.edit');
    Route::put('/user/tasks/{id}', [UserTaskController::class, 'update'])->name('user.tasks.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/tasks/{id}/start', [TaskController::class, 'startTaskInProgress'])->name('tasks.start');
});

require __DIR__.'/auth.php';
