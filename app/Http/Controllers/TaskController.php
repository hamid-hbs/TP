<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // 👈 Importation nécessaire pour Auth::id()

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Utilise Auth::id() pour éviter l'erreur 'Undefined method id'
        $tasks = Task::where('user_id', Auth::id())
                     ->orderBy('created_at', 'desc')
                     ->get();

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'due_date' => 'nullable|date',
        ]);

        Task::create([
            'user_id' => Auth::id(), // Utilisation de Auth::id()
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
        ]);

        return back()->with('success', 'Task created');
    }

    
    public function update(Task $task)
    {
        //$this->authorize('update', $task); 
        
        $task->update([
            'is_completed' => !$task->is_completed
        ]);

        return back();
    }

  
    public function destroy(Task $task)
    {
        //$this->authorize('delete', $task);
        
        $task->delete();

        return back();
    }
}