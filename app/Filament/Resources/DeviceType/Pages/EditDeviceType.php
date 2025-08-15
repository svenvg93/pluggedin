<?php

namespace App\Filament\Resources\DeviceType\Pages;

use App\Filament\Resources\DeviceType\DeviceTypeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDeviceType extends EditRecord
{
    protected static string $resource = DeviceTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
