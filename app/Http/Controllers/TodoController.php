<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @return Response
     */
    public function index(): Response
    {
        $todos = Todo::latestFirst()->get(); //Todo ordering

        return Inertia::render('Todos/Index',[
            'todos'=> $todos
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * 
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Todos/Create');
    }

    /**
     * Store a newly created todo in database.
     * 
     * @param  StoreTodoRequest  $request
     * @return RedirectResponse
     */
    public function store(StoreTodoRequest $request): RedirectResponse
    {
        Todo::create($request->validated());

        return redirect()
            ->route('todos.index')
            ->with('success', 'Todo created successfully!');
    }

    /**
     * Display the specified todo.
     * 
     * @param  Todo  $todo
     * @return Response
     */
    public function show(Todo $todo): Response
    {
       return Inertia::render('Todos/Show', [
            'todo' => $todo,
        ]);
    }

    /**
     * Show the form for editing the specified todo.
     * @param  Todo  $todo
     * @return Response
     */
    public function edit(Todo $todo): Response
    {
        return Inertia::render('Todos/Edit', [
            'todo' => $todo,
        ]);
    }

    /**
     * Update the specified todo in database.
     * 
     * @param  UpdateTodoRequest  $request
     * @param  Todo  $todo
     * @return RedirectResponse
     */
    public function update(UpdateTodoRequest $request, Todo $todo): RedirectResponse
    {
        $todo->update($request->validated());

        return redirect()
            ->route('todos.index')
            ->with('success', 'Todo updated successfully!');
    }

    /**
     * Remove the specified todo from the database.
     * 
     * @param  Todo  $todo
     * @return RedirectResponse
     */
    public function destroy(Todo $todo): RedirectResponse
    {
        $todo->delete();

        return redirect()
            ->route('todos.index')
            ->with('success', 'Todo deleted successfully!');
    }
}
