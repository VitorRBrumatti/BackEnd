<?php

namespace App\Http\Controllers;

use App\Models\Tarefa;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class TarefaController extends Controller
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
       $tarefa = Tarefa::create([
        'title' => $request->input('title'),
        'description' => $request->input('description'),
        'due_date' => $request->input('due_date'),
       ]);
       return response()->json([
        'message' => 'Product created',
        'tarefa' => $tarefa
       ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tarefa  $tarefa)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tarefa $tarefa)
    {
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tarefa $tarefas)
    {
        
    }
}
