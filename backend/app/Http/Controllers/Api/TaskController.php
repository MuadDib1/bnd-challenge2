<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Http\Resources\TaskResource;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $tasks = Task::with('user')->paginate(
            $request->input('per_page', 10)
        );

        return TaskResource::collection($tasks);
    }

    public function userTasks(Request $request, User $user)
    {
        $tasks = $user->tasks()->with('user')->paginate(
            $request->input('per_page', 10)
        );

        return TaskResource::collection($tasks);
    }

    public function store(Request $request, User $user)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => ['required', Rule::in(['pending', 'in_progress', 'completed'])],
            'due_date' => 'nullable|date',
        ]);

        $task = $user->tasks()->create($validated);

        return new TaskResource($task->load('user'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => ['required', Rule::in(['pending', 'in_progress', 'completed'])],
            'due_date' => 'nullable|date',
        ]);

        $task->update($validated);

        return new TaskResource($task->load('user'));
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return response()->noContent();
    }
}
