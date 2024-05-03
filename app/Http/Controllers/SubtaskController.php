<?php

namespace App\Http\Controllers;

use App\Models\Subtask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubtaskController extends Controller
{
    public function store(Request $request)
    {
       $validation = Validator::make($request->all(),[
        'title_subtask' =>  'required|min:3',
        'task_id' => 'required|exists:tasks,id',
        'description_subtask' => 'string',
       ]);

       if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
       }
       $Subtasks = Subtask::create([
        'title_subtask' => $request->input('title_subtask'),
        'task_id' => $request->input('task_id'),
        'description_subtask' => $request->input('description_subtask'),
       ]);
       return response()->json([
        'message' => 'Product created',
        'Subtask' => $Subtasks
       ], 201);
    }

    public function update(Request $request, Subtask  $subtask)
    {
        $validation = Validator::make($request->all(),[
            'title' =>  'min:3',
            'description' => 'string',
            'status' =>  'string|in:pending,completed'
           ]);

           if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
           }

           $subtask->fill($request->input())->update();
           return response()->json([
            'message' => 'Task updated!',
            'subtasks'=> $subtask
           ]);

    }
    public function show(Subtask  $subtask)
    {
        return response()->json($subtask);
    }



    public function destroy(Subtask  $subtask)
    {
        $subtask->delete();
        return response()->json([
            'message' => 'Task deleted!!'
        ]);
    }
}
