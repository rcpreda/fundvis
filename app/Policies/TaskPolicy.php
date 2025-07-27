<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    /**
     * User can view only their own tasks
     */
    public function view(User $user, Task $task): bool
    {
        return $user->id === $task->user_id;
    }


    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * User can create tasks (only for themselves)
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * User can update only their own tasks
     */
    public function update(User $user, Task $task): bool
    {
        return $user->id === $task->user_id;
    }

    /**
     * User can delete only their own tasks
     */
    public function delete(User $user, Task $task): bool
    {
        return $user->id === $task->user_id;
    }

    public function restore(User $user, Task $task): bool
    {
        return $user->id === $task->user_id;
    }

    public function forceDelete(User $user, Task $task): bool
    {
        return false;
    }
}
