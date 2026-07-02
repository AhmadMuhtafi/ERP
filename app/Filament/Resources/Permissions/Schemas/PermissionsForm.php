<?php

namespace App\Filament\Resources\Permissions\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;

class PermissionsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Permission')
                    ->required()
                    // Kita sebutkan nama tabel 'permissions' secara eksplisit agar validasi uniknya tidak bingung
                    ->unique(table: 'permissions', ignoreRecord: true)
                    ->placeholder('Contoh: create_company, edit_user, dll'),
            ]);
    }
}
