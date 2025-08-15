<?php

namespace App\Filament\Resources\DeviceType\Resources\DeviceModels\Pages;

use App\Filament\Resources\DeviceType\Resources\DeviceModels\DeviceModelResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDeviceModel extends CreateRecord
{
    protected static string $resource = DeviceModelResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['type_id'] = $this->getOwnerRecord()->id;
        
        return $data;
    }
}
