<?php

namespace App\Filament\Resources\DeviceTypes\Resources\DeviceModels\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DeviceModelForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('vendor')
                    ->required()
                    ->maxLength(255),
                ColorPicker::make('color')
                    ->required()
                    ->helperText('Color in hex format (e.g., #FF0000)'),
                TextInput::make('comment')
                    ->maxLength(255),
            ]);
    }
}
