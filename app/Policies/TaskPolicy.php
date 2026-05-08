<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    /**
     * Any authenticated user can access the task list.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * A user can view a task if they are the assignee OR a lead on the task's project.
     */
    public function view(User $user, Task $task): bool
    {
        if ($task->user_id === $user->id) {
            return true;
        }

        return $user->projects()
            ->wherePivot('role', 'lead')
            ->where('projects.id', $task->project_id)
            ->exists();
    }

    /**
     * Only users who are a lead on at least one project can create tasks.
     */
    public function create(User $user): bool
    {
        return $user->projects()->wherePivot('role', 'lead')->exists();
    }

    /**
     * Only the lead of the task's project can edit it.
     */
    public function update(User $user, Task $task): bool
    {
        return $user->projects()
            ->wherePivot('role', 'lead')
            ->where('projects.id', $task->project_id)
            ->exists();
    }

    /**
     * Only the lead of the task's project can delete it.
     */
    public function delete(User $user, Task $task): bool
    {
        return $user->projects()
            ->wherePivot('role', 'lead')
            ->where('projects.id', $task->project_id)
            ->exists();
    }

    /**
     * Only the assigned developer can update the status of their own task.
     */
    public function updateStatus(User $user, Task $task): bool
    {
        return $task->user_id === $user->id;
    }
}
