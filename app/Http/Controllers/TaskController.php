<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::all();
        return $tasks;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $task = Task::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'deadline' => $request->input('deadline'),
            'color' => $request->input('color'),
            'priority' => $request->input('priority'),
            'status' => 'in_progress',
            'author_id' => Auth::user()->id,
        ]);

        if ($task)
            return redirect()->route('dashboard')->with(['tasks' => Auth::user()->tasks]);

        return "something went wrong!";
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('dashboard')->with(['tasks' => Auth::user()->tasks]);
    }

    public function changeStatus(Task $task)
    {
        $status = $task->status;
    
        switch ($status) {
            case 'in_progress':
                $task->status = 'finished';
                break;
            case 'finished':
                $task->status = 'in_progress';
                break;
        }
    
        $task->save();
        return redirect()->route('dashboard')->with(['tasks' => Auth::user()->tasks]);
    }    
}
