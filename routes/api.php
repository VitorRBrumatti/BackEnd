<?php

use App\Http\Controllers\SubtaskController;
use App\Http\Controllers\TarefaController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('/task')->controller(TaskController::class)->group(function () {
    Route::post('', 'store');
    Route::get('', 'index');
    Route::get('/{task}', 'show');
    Route::put('/{task}', 'update');
    Route::delete('/{task}', 'destroy');
});

Route::prefix('/Subtask')->controller(SubtaskController::class)->group(function () {
    Route::post('', 'store');
    Route::get('', 'index');
    Route::get('/{Subtask}', 'show');
    Route::put('/{Subtask}', 'update');
    Route::delete('/{Subtask}', 'destroy');
});