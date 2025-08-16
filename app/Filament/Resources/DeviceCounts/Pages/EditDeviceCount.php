<?php

namespace App\Filament\Resources\DeviceCounts\Pages;

use App\Enums\UserRole;
use App\Filament\Resources\DeviceCounts\DeviceCountResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditDeviceCount extends EditRecord
{
    protected static string $resource = DeviceCountResource::class;

    protected function getHeaderActions(): array
    {
        $isAdmin = Auth::user()?->role === UserRole::Admin;

        return [
            DeleteAction::make()
                ->visible(fn (): bool => $isAdmin),
        ];
    }
}
