<?php

namespace App\Filament\Resources\DeviceTypes\Resources\DeviceModels\Pages;

use App\Filament\Resources\DeviceTypes\Resources\DeviceModels\DeviceModelResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDeviceModel extends EditRecord
{
    protected static string $resource = DeviceModelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
