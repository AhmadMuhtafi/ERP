<?php

namespace App\Filament\Resources\Permissions;

use App\Filament\Resources\Permissions\Pages\CreatePermissions;
use App\Filament\Resources\Permissions\Pages\EditPermissions;
use App\Filament\Resources\Permissions\Pages\ListPermissions;
use App\Filament\Resources\Permissions\Schemas\PermissionsForm;
use App\Filament\Resources\Permissions\Tables\PermissionsTable;
use App\Models\Permissions;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use App\Filament\Resources\BaseResource;

class PermissionsResource extends BaseResource
{
    protected static ?string $model = \Spatie\Permission\Models\Permission::class;

    protected static ?string $permissionResource = 'permission';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return PermissionsForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PermissionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPermissions::route('/'),
            'create' => CreatePermissions::route('/create'),
            'edit' => EditPermissions::route('/{record}/edit'),
        ];
    }
}
