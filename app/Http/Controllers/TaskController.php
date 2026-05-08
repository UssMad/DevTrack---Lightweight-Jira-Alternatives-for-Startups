<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaskController extends Controller
{
    use AuthorizesRequests;

    /**
     * US8 – List tasks.
     * Leads see all tasks from projects they lead.
     * Developers see only their assigned tasks.
     */
    public function index()
    {
        $this->authorize('viewAny', Task::class);

        $user = Auth::user();

        $isLead = $user->projects()->wherePivot('role', 'lead')->exists();

        if ($isLead) {
            $leadProjectIds = $user->projects()
                ->wherePivot('role', 'lead')
                ->pluck('projects.id');

            $tasks = Task::with('project', 'user')
                ->whereIn('project_id', $leadProjectIds)
                ->when(request('project'), fn($q) => $q->where('project_id', request('project')))
                ->when(request('status'),  fn($q) => $q->where('status', request('status')))
                ->latest()
                ->get();
        } else {
            $tasks = $user->tasks()->with('project')->latest()->get();
        }

        $projects = $user->projects;

        return view('tasks.index', compact('tasks', 'projects'));
    }

    /**
     * US9 – Show create form (leads only).
     */
    public function create()
    {
        $this->authorize('create', Task::class);

        $projects = Auth::user()->projects()->wherePivot('role', 'lead')->with('users')->get();

        return view('tasks.create', compact('projects'));
    }

    /**
     * US9 – Store a new task.
     */
    public function store(StoreTaskRequest $request)
    {
        Task::create($request->validated());

        return redirect()->route('tasks.index')->with('success', 'Tâche créée avec succès.');
    }

    /**
     * US8 – Show a single task's details.
     */
    public function show(Task $task)
    {
        $this->authorize('view', $task);

        $task->load('project', 'user');

        return view('tasks.show', compact('task'));
    }

    /**
     * US10 – Show the edit form (lead of task's project only).
     */
    public function edit(Task $task)
    {
        $this->authorize('update', $task);

        $projects = Auth::user()->projects()->wherePivot('role', 'lead')->with('users')->get();

        return view('tasks.edit', compact('task', 'projects'));
    }

    /**
     * US10 – Update a task (lead only).
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->validated());

        return redirect()->route('tasks.show', $task)->with('success', 'Tâche mise à jour.');
    }

    /**
     * US12 – Delete a task (lead only).
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Tâche supprimée.');
    }

    /**
     * US11 – Developer updates their own task's status only.
     */
    public function updateStatus(Request $request, Task $task)
    {
        $this->authorize('updateStatus', $task);

        $request->validate([
            'status' => 'required|in:todo,in_progress,done',
        ]);

        $task->update(['status' => $request->status]);

        return back()->with('success', 'Statut mis à jour.');
    }
}
