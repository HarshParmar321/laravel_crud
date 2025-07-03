<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;


// Redirect root '/' to the tasks list
Route::get('/', function () {
    return redirect()->route('tasks.index');
});

// Task resource routes
Route::resource('tasks', TaskController::class);



Route::get('/debug-error', function () {
    if (File::exists(storage_path('logs/laravel.log'))) {
        return nl2br(file_get_contents(storage_path('logs/laravel.log')));
    }
    return 'Log file not found';
});


Route::get('/migrate-now', function () {
    try {
        Artisan::call('migrate', ['--force' => true]);
        return '✅ Migration complete!';
    } catch (\Exception $e) {
        return '❌ Migration failed: ' . $e->getMessage();
    }
});