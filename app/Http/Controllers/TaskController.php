<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Task::with('subtasks');

        if ($request->input('filter') === 'overdue') {
            $query->where('due_date', '<', Carbon::now()->startOfDay());
        }
        if ($request->input('filter') === 'today') {
            $query->whereDate('due_date', Carbon::today()->startOfDay());
        }
        return $query->paginate($request->input('per_page') ?? 10);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'title' =>  'required|min:3',
            'description' => 'string',
            'due_date' => 'required|date'
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }
        $task = Task::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'due_date' => $request->input('due_date'),
        ]);
        return response()->json([
            'message' => 'Product created',
            'task' => $task
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task  $task)
    {
        return response()->json($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $validation = Validator::make($request->all(), [
            'title' =>  'min:3',
            'description' => 'string',
            'due_date' => 'date',
            'status' =>  'string|in:pending,completed'
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }

        $task->fill($request->input())->update();
        return response()->json([
            'message' => 'Task updated!',
            'tasks' => $task
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json([
            'message' => 'Subtask deleted!!'
        ]);
    }
}
