<?php

namespace App\Filament\Resources;

use Filament\Resources\Resource;

abstract class BaseResource extends Resource
{
    /**
     * Contoh:
     * company
     * user
     * role
     */
    protected static ?string $permissionResource = null;

    protected static function getViewPermission(): ?string
    {
        if (blank(static::$permissionResource)) {
            return null;
        }

        return 'view_' . static::$permissionResource;
    }

    public static function canAccess(): bool
    {
        $permission = static::getViewPermission();

        if ($permission === null) {
            return true;
        }

        return auth()->user()?->can($permission) ?? false;
    }

    public static function shouldRegisterNavigation(): bool
    {
        return static::canAccess();
    }
}
