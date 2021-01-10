<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Services\Task\SaveTask;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;

class TaskController extends Controller
{
    public function list()
    {
        $tasks = Task::statusActive()->createdToday()->get();
        return TaskResource::collection($tasks);
    }

    public function save(TaskRequest $request, Task $task = null)
    {
        $formData = $request->all();
        $saveTask = new SaveTask($formData, $task);
        return response()->json($saveTask->handle());
    }

    public function task(Task $task)
    {
        return new TaskResource($task);
    }

    public function conclude(Task $task)
    {
        $formData = ['status' => Task::STATUS_CONCLUDED];
        $saveTask = new SaveTask($formData, $task);
        return response()->json($saveTask->handle());
    }

    public function archive(Task $task)
    {
        $formData = ['status' => Task::STATUS_ARCHIVED];
        $saveTask = new SaveTask($formData, $task);
        return response()->json($saveTask->handle());
    }
}
