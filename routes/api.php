<?php

use App\Http\Controllers\TarefaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('/tarefa')->controller(TarefaController::class)->group(function () {
    Route::post('', 'store');
    Route::get('', 'index');
    Route::get('/{tarefa}', 'show');
    Route::put('/{tarefa}', 'update');
    Route::delete('/{tarefa}', 'destroy');
});