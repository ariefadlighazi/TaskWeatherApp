<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Http\Resources\TaskResource;
use Illuminate\Http\Response;

class TaskApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $tasks = Task::query()->where('user_id', auth()->id())->latest()->paginate();
        return TaskResource::collection($tasks);
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

        $task = Task::create([
            'user_id'       => auth()->id(),
            'title'         => $data['title'],
            'description'   => $data['description'] ?? null,
            'due_date'      => $data['due_date'] ?? null,
            'is_completed'  => false,
        ]);

        return (new TaskResource($task))
                ->response()
                ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
        $this->authorizeOwner($task);

        return new TaskResource($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        //
        $this->authorizeOwner($task);
        $data = $request->validate([
            'title'         => 'sometimes|required|string|max:255',
            'description'   => 'sometimes|nullable|string',
            'due_date'      => 'sometimes|nullable|date',
            'is_completed'  => 'sometimes|boolean',
        ]);

        $task->update($data);

        return new TaskResource($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
        $task->authorizeOwner($task);

        $task->delete();

        return response()->noContent();
    }

    private function authorizeOwner(Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            abort(Response::HTTP_FORBIDDEN, 'You are not authorized to access this resource.');
        }
    }
}
