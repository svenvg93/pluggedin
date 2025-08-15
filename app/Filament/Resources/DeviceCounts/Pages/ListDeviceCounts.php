<?php

namespace App\Filament\Resources\DeviceCounts\Pages;

use App\Filament\Resources\DeviceCounts\DeviceCountResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDeviceCounts extends ListRecords
{
    protected static string $resource = DeviceCountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
