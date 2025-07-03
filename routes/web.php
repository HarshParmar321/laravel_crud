<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

// Redirect root '/' to the tasks list
Route::get('/', function () {
    return redirect()->route('tasks.index');
});

// Task resource routes
Route::resource('tasks', TaskController::class);
