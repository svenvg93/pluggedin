<?php

namespace App\Filament\Resources\DeviceTypes\Resources\DeviceModels\Pages;

use App\Filament\Resources\DeviceTypes\Resources\DeviceModels\DeviceModelResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDeviceModel extends CreateRecord
{
    protected static string $resource = DeviceModelResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['type_id'] = $this->getParentRecord()->id;

        return $data;
    }
}
