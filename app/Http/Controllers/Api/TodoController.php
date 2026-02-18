<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Http\Resources\TodoResource;
use App\Models\Todo;
use App\Support\ApiResponse;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *  Example: GET /api/todos?per_page=10
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Todo::query()->where('user_id', $user->id);

        $todos = $query->orderByDesc('created_at')->paginate($request->integer('per_page', 10));

        return ApiResponse::success(
            TodoResource::collection($todos),
            'Todos retrieved successfully',
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     * Example: POST /api/todos
     */
    public function store(StoreTodoRequest $request)
    {

        $todo = Todo::create([
            ...$request->validated(),
            'user_id' => $request->user()->id,
        ]);

        return ApiResponse::success(
            new TodoResource($todo),
            'Todo created successfully',
            201
        );
    }

    /**
     * Display the specified resource.
     * Example: GET /api/todos/{id}
     */
    public function show(Request $request, string $id)
    {
        $user = $request->user();
        $todo = Todo::where('user_id', $user->id)->find($id);

        if (!$todo) {
            return ApiResponse::error('Todo not found', null, 404);
        }

        return ApiResponse::success(
            new TodoResource($todo),
            'Todo fetched',
            200
        );
    }

    /**
     * Update the specified resource in storage.
     * Example: PUT /api/todos/{id}
     */
    public function update(UpdateTodoRequest $request, string $id)
    {
        $user = $request->user();
        $todo = Todo::where('user_id', $user->id)->find($id);

        if (!$todo) {
            return ApiResponse::error('Todo not found', null, 404);
        }

        $todo->update($request->validated());

        return ApiResponse::success(
            new TodoResource($todo),
            'Todo updated successfully',
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     * Example: DELETE /api/todos/{id} (soft delete)
     */
    public function destroy(Request $request, int $id)
    {
        $todo = Todo::where('user_id', $request->user()->id)->find($id);

        if (!$todo) {
            return ApiResponse::error('Todo not found', null, 404);
        }

        $todo->delete();

        return ApiResponse::success(
            null,
            'Todo deleted successfully',
            200
        );
    }

    /**
     * Toggle the completed status of a todo.
     * Example: PATCH /api/todos/{id}/toggle
     */
    public function toggle(Request $request, int $id)
    {
        $todo = Todo::where('user_id', $request->user()->id)->find($id);

        if (!$todo) {
            return ApiResponse::error('Todo not found', null, 404);
        }

        $todo->completed = !$todo->completed;
        $todo->save();

        return ApiResponse::success(
            new TodoResource($todo),
            'Todo toggled successfully',
            200
        );
    }
}
