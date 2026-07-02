<?php

namespace App\Policies;

use App\Models\User;

abstract class BasePolicy
{
    protected string $resource;

    public function before(User $user): ?bool
    {
        if ($user->hasRole('Super Admin')) {
            return true;
        }

        return null;
    }

    protected function check(User $user, string $action): bool
    {
        return $user->can("{$action}_{$this->resource}");
    }

    public function viewAny(User $user): bool
    {
        return $this->check($user, 'view');
    }

    public function view(User $user, mixed $model): bool
    {
        return $this->check($user, 'view');
    }

    public function create(User $user): bool
    {
        return $this->check($user, 'create');
    }

    public function update(User $user, mixed $model): bool
    {
        return $this->check($user, 'update');
    }

    public function delete(User $user, mixed $model): bool
    {
        return $this->check($user, 'delete');
    }

    public function deleteAny(User $user): bool
    {
        return $this->check($user, 'delete');
    }

    public function restore(User $user, mixed $model): bool
    {
        return $this->check($user, 'restore');
    }

    public function restoreAny(User $user): bool
    {
        return $this->check($user, 'restore');
    }

    public function forceDelete(User $user, mixed $model): bool
    {
        return $this->check($user, 'force_delete');
    }

    public function forceDeleteAny(User $user): bool
    {
        return $this->check($user, 'force_delete');
    }
}
