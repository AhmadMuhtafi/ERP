<?php

namespace App\Filament\Resources\Companies\Schemas;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CompanyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('npwp'),
                TextInput::make('address'),
                TextInput::make('phone')
                    ->tel(),
                FileUpload::make('logo')
                    ->image()
                    ->directory('company-logos')
                    ->maxSize(2048),
                TextInput::make('currency')
                    ->required()
                    ->default('IDR'),
                TextInput::make('timezone')
                    ->required()
                    ->default('Asia/Jakarta'),
            ]);
    }
}
