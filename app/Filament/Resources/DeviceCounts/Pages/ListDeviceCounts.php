<?php

namespace App\Filament\Resources\DeviceCounts\Pages;

use App\Enums\UserRole;
use App\Filament\Resources\DeviceCounts\DeviceCountResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListDeviceCounts extends ListRecords
{
    protected static string $resource = DeviceCountResource::class;

    protected function getHeaderActions(): array
    {
        $isAdmin = Auth::user()?->role === UserRole::Admin;

        return [
            CreateAction::make()
                ->visible(fn (): bool => $isAdmin),
        ];
    }
}
