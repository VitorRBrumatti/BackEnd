<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Symfony\Component\Console\Input\Input;

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
            'title' => 'required|min:3',
            'description' => 'string',
            'due_date' => 'required|date'
        ], [
            'title.required' => 'O campo :attribute é obrigatório.',
            'title.min' => 'O campo :attribute deve ter pelo menos :min caracteres.',
            'description.string' => 'O campo :attribute deve ser uma string.',
            'due_date.required' => 'O campo :attribute é obrigatório.',
            'due_date.date' => 'O campo :attribute deve ser uma data válida.'
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
        $task->fill($request->input());
        $task->update();

        if ($request->has('status') && $request->input('status') === 'completed') {
            $task->subtasks()->update(['status_subtask' => 'completed']);
        }  else if ($request->has('status') && $request->input('status') === 'pending') {
            $task->subtasks()->update(['status_subtask' => 'pending']);
        }

        return response()->json([
            'message' => 'Task updated!',
            'tasks' => $task->load('subtasks')
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
