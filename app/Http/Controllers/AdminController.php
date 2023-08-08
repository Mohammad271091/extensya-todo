<?php

namespace App\Http\Controllers;

use App\Events\DeleteTaskEvent;
use App\Models\Task;
use App\Models\User;
use App\Events\NewTaskEvent;
use App\Events\PrivateRealTimeNotificationEvent;
use App\Events\UpdateTaskEvent;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index')->with('tasks',  Task::all())->with('users', User::all());
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'task' => 'required|string|max:100',
                'description' => 'required|string|max:200',
            ],
            [
                'task.required' => 'The task is required',
                'description.required' => 'The description is required'
            ]
        );

        $task = Task::create([
            'task' => $request->input('task'),
            'description' => $request->input('description'),
        ]);

        event(new NewTaskEvent('A new task called ' . $request->input('task') . ' has been added! <i class="fa fa-refresh text-danger" onClick="location.reload()"></i>'));

        return response()->json([
            'id' => $task->id,
            'task' => $task->task,
            'created_at' => $task->created_at,
            'description' => $task->description,
        ]);
    }

    public function destroy(Request $request, $id)
    {
        // Get the task by its ID
        $task = Task::find($id);

        // delete it !
        $task->delete();

        event(new DeleteTaskEvent('A task has been deleted! <i class="fa fa-refresh" onClick="location.reload()"></i>'));

        // Return a success response
        return response()->json(['message' => 'Task deleted successfully']);
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'task' => 'required|string|max:100',
                'description' => 'required|string|max:200',
            ],
            [
                'task.required' => 'The task is required',
                'description.required' => 'The description is required',
                'task.max' => 'Maximum allowd characters is 100',
                'description.max' => 'Maximum allowd characters is 200',
            ]
        );

        $task = Task::findOrFail($id);
        $task->update([
            'task' => $request->input('task'),
            'description' => $request->input('description'),
        ]);

        event(new UpdateTaskEvent('The task ' . $request->input('task') . ' was updated by the admin! <i class="fa fa-refresh" onClick="location.reload()"></i>'));


        return response()->json(['message' => 'Task updated successfully']);
    }

    public function privateNotification(Request $request)
    {
        $user = User::find($request->input('userId'));
        $message = $request->input('message');
        event(new PrivateRealTimeNotificationEvent($user, $message));
        return response()->json(['message' => 'Private notification sent successfully']);
    }
}
