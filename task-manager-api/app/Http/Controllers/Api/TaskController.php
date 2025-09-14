<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Models\Keyword;
use App\Models\Task;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    public function index(): JsonResponse
    {
        $tasks = Task::with('keywords')->orderBy('created_at', 'desc')->get();
        return response()->json($tasks);
    }

    public function store(StoreTaskRequest $request): JsonResponse
    {
        $task = Task::create([
            'title' => $request->input('title'),
            'is_done' => false,
        ]);

        if ($request->has('keyword_ids')) {
            $task->keywords()->sync($request->input('keyword_ids'));
        }

        return response()->json($task->load('keywords'), 201);
    }

    public function toggle(string $id): JsonResponse
    {
        $task = Task::findOrFail($id);
        $task->is_done = !$task->is_done;
        $task->save();

        return response()->json($task->load('keywords'));
    }
}