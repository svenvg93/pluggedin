<?php

namespace App\Filament\Resources\DeviceTypes\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class DeviceTypeForm
{
    public static function schema(): array
    {
        return [
            TextInput::make('name')
                ->required()
                ->maxLength(255)
                ->unique(ignoreRecord: true)
                ->label('Type'),
            ColorPicker::make('color')
                ->required()
                ->label('Color')
                ->placeholder('#FFFFFF'),
            Textarea::make('comment')
                ->label('Comment')
                ->columnSpanFull(),
        ];
    }
}
