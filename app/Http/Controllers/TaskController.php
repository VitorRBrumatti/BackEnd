<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $validation = Validator::make($request->all(),[
        'title' =>  'required|min:3',
        'description' => 'string',
        'due_date' => 'required|date'
       ]);

       if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
       }
       $tasks = Task::create([
        'title' => $request->input('title'),
        'description' => $request->input('description'),
        'due_date' => $request->input('due_date'),
       ]);
       return response()->json([
        'message' => 'Product created',
        'task' => $tasks
       ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task  $tasks)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $tasks)
    {
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $tasks)
    {
        
    }
}
