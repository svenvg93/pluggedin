<?php

namespace App\Filament\Resources\DeviceTypes\Pages;

use App\Filament\Resources\DeviceTypes\DeviceTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDeviceTypes extends ListRecords
{
    protected static string $resource = DeviceTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            // We'll add a custom widget here
        ];
    }

    protected function getHeaderDescription(): ?string
    {
        return 'Manage device types and their associated models. Click on a device type to edit it and access the "Device Models" tab to manage its models.';
    }


}
