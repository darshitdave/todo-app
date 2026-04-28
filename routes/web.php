<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;

Route::resource('todos', TodoController::class); //creates all standard crud routes

Route::get('/', function () {
    return redirect()->route('todos.index');
});
