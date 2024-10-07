<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task; // Importar el modelo Task

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
        public function index()
    {
        $tasks = Task::all();
        return view('tasks.index', compact('tasks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        Task::create([
            'title' => $request->title,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Tarea creada con éxito.');
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $task->update([
            'title' => $request->title,
            'is_completed' => $request->has('is_completed'),
        ]);

        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index');
    }
}
