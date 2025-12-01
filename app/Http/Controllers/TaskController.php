<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $tasks = Task::where('user_id', auth()->id())
                    ->latest()
                    ->get();

        $cfg = config('services.openweather');
        $q = [
            'q' => $cfg['city'],
            'appid' => $cfg['api_key'],
            'units' => $cfg['units'],
        ];
        $weather = Http::get($cfg['endpoint'], $q)->json();

        return view('tasks.index', compact('tasks', 'weather'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = $request->validate([
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'due_date'      => 'nullable|date',
        ]);

        $data['user_id'] = auth()->id();

        Task::create($data);

        return redirect()->route('tasks.index')
                         ->with('success', 'Task created successfully.');
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
        $this->authorizeTask($task);

        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        //
        $this->authorizeTask($task);

        $data = $request->validate([
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'due_date'      => 'nullable|date',
            'is_completed'  => 'sometimes|boolean',
        ]);

        $task->update($data);

        return redirect()->route('tasks.index')
                         ->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
        $this->authorizeTask($task);

        $task->delete();
        return redirect()->route('tasks.index')
                         ->with('success', 'Task deleted successfully.');
    }

    public function toggle(Request $request, Task $task)
    {
        //
        $this->authorizeTask($task);

        $task->update([
            'is_completed' => ! (bool) $task->is_completed
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'is_completed' => $task->is_completed
            ]);
        }
        return redirect()->route('tasks.index')->with('success', 'Task status updated successfully.');
    }

    protected function authorizeTask(Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            abort(403);
        }
    }
}
