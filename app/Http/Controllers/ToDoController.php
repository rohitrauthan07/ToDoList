<?php

namespace App\Http\Controllers;
use App\Models\ToDo;
use Illuminate\Http\Request;

/**
 * Validate the request
 * Rohit Singh <rohit07rsr@gmail.com>
 * 07th Sept 2024
 */
class ToDoController extends Controller
{
    public function index(Request $request)
    {
        $showAll = $request->get('show_all', 0);
        if ($showAll) {
            $todos = ToDo::all();
        } else {
            $todos = ToDo::where('status', 0)->get();
        }
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'todos' => $todos,
            ]);
        }

        return view('todos.index', compact('todos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:todos',
        ]);
        $task = Todo::create([
            'name' => $request->name,
            'status' => false,
        ]);
        return response()->json(['success' => true, 'task' => $task]);
    }

    public function updateStatus($id)
    {
        $task = Todo::findOrFail($id);
        $task->status = !$task->status;
        $task->save();
        return response()->json(['success' => true, 'status' => $task->status]);
    }

    public function destroy($id)
    {
        $todo = ToDo::find($id);

        if ($todo) {
            $todo->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 404);
    }

    public function showAll()
    {
        $todos = Todo::all();
        return response()->json(['todos' => $todos]);
    }

}