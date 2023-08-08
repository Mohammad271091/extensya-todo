<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{

    public function login(Request $request)
    {
        // if incorrect credentials 
        if (!Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            return response()->json([
                "status" => 401,
                "success" => false,
                "message" => "Unauthorized"
            ]);
        }

        $user = Auth::user();

        // if ($user->is_admin === 1) {
        //     $token = $user->createToken('token', ['create-task']);
        // } else {
        //     $token = $user->createToken('token');
        // }

        $token = $user->createToken('token');

        return response()->json([
            "status" => 200,
            "success" => true,
            "token" => $token->plainTextToken
        ]);
    }


    public function tasks()
    {
        $tasks = Cache::remember('tasks', 60 * 60 * 24, function () {
            return Task::all();
        });

        return response()->json([
            "status" => 200,
            "success" => true,
            "data" => $tasks
        ]);
    }

    public function createTask(Request $request)
    {
        if (Auth::user()->is_admin) {
            // Validate request data
            $validator = Validator::make($request->all(), [
                'task' => 'required|string|max:100',
                'description' => 'required|string|max:200',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'success' => false,
                    'errors' => $validator->errors(),
                ], 400);
            }

            // Create and save the new task
            $task = Task::create([
                'task' => $request->input('task'),
                'description' => $request->input('description'),
                'created_at' => now(),
            ]);

            return response()->json([
                'status' => 201,
                'success' => true,
                'message' => 'Task created successfully',
                'data' => $task,
            ], 201);
        } else {
            return response()->json([
                'status' => 403,
                'message' => "you don't have permission to add tasks"
            ], 403);
        }
    }

    public function deleteTask(Request $request, $taskId)
    {
        $user = Auth::user();

        $task = Task::find($taskId);

        if (!$task) {
            return response()->json([
                'status' => 404,
                'success' => false,
                'message' => 'Task not found',
            ], 404);
        }

        // Check if the user is not admin
        if (!$user->is_admin) {
            return response()->json([
                'status' => 403,
                'success' => false,
                'message' => 'You do not have permission to delete this task',
            ], 403);
        }

        // Delete the task
        $task->delete();

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Task deleted successfully',
        ]);
    }

    public function updateTask(Request $request, $taskId)
    {
        $user = Auth::user();

        $task = Task::find($taskId);

        if (!$task) {
            return response()->json([
                'status' => 404,
                'success' => false,
                'message' => 'Task not found',
            ], 404);
        }

        // Check if the user is not admin
        if (!$user->is_admin) {
            return response()->json([
                'status' => 403,
                'success' => false,
                'message' => 'You do not have permission to update this task',
            ], 403);
        }

        // Validate request data
        $validator = Validator::make($request->all(), [
            'task' => 'required|string|max:100',
            'description' => 'required|string|max:200',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'success' => false,
                'errors' => $validator->errors(),
            ], 400);
        }

        $task->update([
            'task' => $request->input('task'),
            'description' => $request->input('description'),
        ]);

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Task updated successfully',
            'data' => $task,
        ]);
    }

    public function viewTask($taskId)
    {
        $user = Auth::user();

        $task = Task::find($taskId);

        if (!$task) {
            return response()->json([
                'status' => 404,
                'success' => false,
                'message' => 'Task not found',
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'success' => true,
            'data' => [
                'task' => $task->task,
                'description' => $task->description,
            ],
        ]);
    }
}

// 38|0l1GYP1Jku3KbCTfphFO5pCizCtJsDmQIW1Scunp

//39|kUtTgFAGsqp6AyFxMrFMVmkODkSgpQhOljE9QbQU sara