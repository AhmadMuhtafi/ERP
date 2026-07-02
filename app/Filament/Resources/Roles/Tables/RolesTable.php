<?php

namespace App\Filament\Resources\Roles\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class RolesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('name')
                    ->label('Nama Role')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('permissions_count')
                    ->label('Jumlah Permission')
                    ->counts('permissions')
                    ->badge()
                    ->color('success')
                    ->sortable(),

                TextColumn::make('modules')
                    ->label('Modul')
                    ->state(function ($record) {

                        return $record->permissions
                            ->groupBy(function ($permission) {
                                return Str::headline(
                                    Str::after($permission->name, '_')
                                );
                            })
                            ->map(function ($permissions, $module) {
                                return "{$module} ({$permissions->count()})";
                            })
                            ->implode(', ');

                    })
                    ->wrap(),

                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])

            ->filters([

                SelectFilter::make('permission')
                    ->label('Permission')
                    ->relationship('permissions', 'name')
                    ->searchable()
                    ->preload(),

            ])

            ->recordActions([
                EditAction::make(),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
