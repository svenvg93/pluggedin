<?php

namespace App\Filament\Resources\DeviceCounts\Schemas;

use App\Models\DeviceModel;
use Filament\Forms\Components\DatePicker;
use Carbon\Carbon;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DeviceCountForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('model_id')
                    ->label('Device Model')
                    ->options(DeviceModel::with('deviceType')->get()->mapWithKeys(function ($model) {
                        return [$model->id => $model->vendor . ' - ' . $model->name];
                    }))
                    ->required()
                    ->searchable()
                    ->preload(),
                DatePicker::make('recorded_at')
                    ->default(Carbon::now())
                    ->native(false)
                    ->required(),
                TextInput::make('count')
                    ->required()
                    ->numeric()
                    ->inputMode('numeric')
                    ->default(0),
                TextInput::make('comment'),
            ]);
    }
}
