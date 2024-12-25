<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string|max:1000',
                'due_date' => 'required|date',
            ]);

            $task = Task::create([
                'title' => $request->title,
                'description' => $request->description,
                'due_date' => $request->due_date,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Task created successfully!',
                'task' => $task
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the task. Please try again later.'
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'title' => 'sometimes|string|max:255',
                'description' => 'sometimes|string',
                'status' => 'sometimes|in:pending,in-progress,completed',
                'due_date' => 'sometimes|date',
            ]);

            $task = Task::findOrFail($id);

            if ($request->has('status')) {
                $task->status = $request->input('status');
            }

            if ($request->has('title')) {
                $task->title = $request->input('title');
            }

            if ($request->has('description')) {
                $task->description = $request->input('description');
            }

            if ($request->has('due_date')) {
                $task->due_date = $request->input('due_date');
            }

            $task->save();

            return response()->json([
                'success' => true,
                'message' => 'Task status updated successfully.',
                'task' => $task
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the task. Please try again later.'
            ], 500);
        }
    }
}
