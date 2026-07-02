<?php

namespace App\Filament\Resources\Roles\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\CheckboxList;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;

class RoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Role')
                    ->required()
                    ->unique(table: 'roles', ignoreRecord: true),

                CheckboxList::make('permissions')
                    ->options(function () {

                        return Permission::query()
                            ->orderBy('name')
                            ->pluck('name', 'id')
                            ->map(function ($permission) {

                                $action = Str::headline(Str::before($permission, '_'));
                                $module = Str::headline(Str::after($permission, '_'));

                                return "{$module} • {$action}";
                            });

                    })
                    ->relationship('permissions', 'name')
                    ->bulkToggleable()
                    ->searchable()
                    ->columns(2),
            ]);
    }
}
