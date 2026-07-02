<?php

namespace App\Filament\Resources\Permissions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class PermissionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('name')
            ->columns([
                TextColumn::make('module')
                    ->label('Module')
                    ->state(fn ($record) => Str::headline(Str::after($record->name, '_')))
                    ->badge(),

                TextColumn::make('action')
                    ->label('Action')
                    ->state(fn ($record) => Str::headline(Str::before($record->name, '_')))
                    ->badge(),

                TextColumn::make('name')
                    ->label('Permission')
                    ->searchable()
                    ->sortable()
                    ->copyable(),

                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])

            ->filters([

                // Filter Module
                SelectFilter::make('module')
                    ->options(function () {
                        return \Spatie\Permission\Models\Permission::query()
                            ->pluck('name')
                            ->mapWithKeys(function ($permission) {
                                $module = Str::after($permission, '_');

                                return [
                                    $module => Str::headline($module),
                                ];
                            })
                            ->unique();
                    })
                    ->query(function (Builder $query, array $data) {
                        if (! filled($data['value'])) {
                            return;
                        }

                        $query->where('name', 'like', '%_' . $data['value']);
                    }),

                // Filter Action
                SelectFilter::make('action')
                    ->options([
                        'view' => 'View',
                        'create' => 'Create',
                        'update' => 'Update',
                        'delete' => 'Delete',
                    ])
                    ->query(function (Builder $query, array $data) {
                        if (! filled($data['value'])) {
                            return;
                        }

                        $query->where('name', 'like', $data['value'] . '_%');
                    }),

                // Filter Created At
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('from'),
                        DatePicker::make('until'),
                    ])
                    ->query(function (Builder $query, array $data) {

                        return $query
                            ->when(
                                $data['from'],
                                fn (Builder $query, $date) => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['until'],
                                fn (Builder $query, $date) => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
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
