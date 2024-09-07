<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ToDoController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [ToDoController::class, 'index'])->name('todos.index');
Route::get('/todos', [ToDoController::class, 'index'])->name('todos.index');
Route::post('/todos', [TodoController::class, 'store'])->name('todos.store');
Route::patch('/todos/{id}/status', [ToDoController::class, 'updateStatus'])->name('todos.updateStatus');
Route::delete('/todos/{id}', [TodoController::class, 'destroy'])->name('todos.destroy');