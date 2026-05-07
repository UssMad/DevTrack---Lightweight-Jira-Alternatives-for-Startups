<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaskController extends Controller
{
    use AuthorizesRequests;

    /**
     * List tasks — admins see all, members see only their tasks.
     */
    public function index()
    {
        $this->authorize('viewAny', Task::class);

        $user = Auth::user();

        if ($user->is_admin) {
            $tasks = Task::with('project', 'user')
                ->when(request('project'), fn($q) => $q->where('project_id', request('project')))
                ->when(request('status'),  fn($q) => $q->where('status',     request('status')))
                ->latest()
                ->get();
        } else {
            $tasks = $user->tasks()->with('project')->latest()->get();
        }

        $projects = $user->projects;

        return view('tasks.index', compact('tasks', 'projects'));
    }

    /**
     * Show the form to create a new task inside a project.
     */
    public function create()
    {
        $this->authorize('create', Task::class);

        $projects = Auth::user()->projects()->wherePivot('role', 'lead')->get();

        return view('tasks.create', compact('projects'));
    }

    /**
     * Store a new task.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Task::class);

        $data = $request->validate([
            'project_id'  => 'required|exists:projects,id',
            'user_id'     => 'nullable|exists:users,id',
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'status'      => 'required|in:todo,in_progress,done',
            'priority'    => 'required|in:low,medium,high',
            'deadline'    => 'required|date',
        ]);

        Task::create($data);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    /**
     * Show a single task's details.
     */
    public function show(Task $task)
    {
        $this->authorize('view', $task);

        $task->load('project', 'user');

        return view('tasks.show', compact('task'));
    }

    /**
     * Show the edit form for an existing task.
     */
    public function edit(Task $task)
    {
        $this->authorize('update', $task);

        $projects = Auth::user()->projects()->wherePivot('role', 'lead')->get();

        return view('tasks.edit', compact('task', 'projects'));
    }

    /**
     * Update an existing task's full details.
     */
    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $data = $request->validate([
            'project_id'  => 'required|exists:projects,id',
            'user_id'     => 'nullable|exists:users,id',
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'status'      => 'required|in:todo,in_progress,done',
            'priority'    => 'required|in:low,medium,high',
            'deadline'    => 'required|date',
        ]);

        $task->update($data);

        return redirect()->route('tasks.show', $task)->with('success', 'Task updated successfully.');
    }

    /**
     * Delete a task.
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    /**
     * Allow the assigned user to update only the status of their task.
     */
    public function updateStatus(Request $request, Task $task)
    {
        $this->authorize('updateStatus', $task);

        $request->validate([
            'status' => 'required|in:todo,in_progress,done',
        ]);

        $task->update(['status' => $request->status]);

        return back()->with('success', 'Status updated.');
    }
}
