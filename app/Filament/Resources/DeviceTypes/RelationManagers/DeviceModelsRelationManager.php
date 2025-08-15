<?php

namespace App\Filament\Resources\DeviceTypes\RelationManagers;

use App\Filament\Resources\DeviceTypes\Resources\DeviceModels\DeviceModelResource;
use App\Filament\Resources\DeviceTypes\Resources\DeviceModels\Tables\DeviceModelTable;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class DeviceModelsRelationManager extends RelationManager
{
    protected static string $relationship = 'deviceModels';

    protected static ?string $relatedResource = DeviceModelResource::class;

    public function table(Table $table): Table
    {
        return DeviceModelTable::configure($table);

    }
}
