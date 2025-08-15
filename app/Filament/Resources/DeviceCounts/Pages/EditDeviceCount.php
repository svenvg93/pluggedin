<?php

namespace App\Filament\Resources\DeviceCounts\Pages;

use App\Filament\Resources\DeviceCounts\DeviceCountResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDeviceCount extends EditRecord
{
    protected static string $resource = DeviceCountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
