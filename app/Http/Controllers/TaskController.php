<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Services\Task\SaveTask;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;

class TaskController extends Controller
{
    public function list(Request $request)
    {
        $filters = $request->all();

        if(!empty($filters)) {
            $tasks = Task::filters($filters)->get();
        } else {
            $tasks = Task::createdToday()->get();
        }

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
        $task->load('tags');
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

    public function active(Task $task)
    {
        $formData = ['status' => Task::STATUS_ACTIVE];
        $saveTask = new SaveTask($formData, $task);
        return response()->json($saveTask->handle());
    }
}
