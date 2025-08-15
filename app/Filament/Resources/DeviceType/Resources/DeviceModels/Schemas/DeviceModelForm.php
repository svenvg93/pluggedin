<?php

namespace App\Filament\Resources\DeviceType\Resources\DeviceModels\Schemas;

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
                    ->maxLength(255),
                ColorPicker::make('color')
                    ->helperText('Color in hex format (e.g., #FF0000)'),
                TextInput::make('comment')
                    ->maxLength(255),
            ]);
    }
}
