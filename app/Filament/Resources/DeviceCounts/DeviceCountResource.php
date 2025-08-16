<?php

namespace App\Filament\Resources\DeviceCounts;

use App\Enums\UserRole;
use App\Filament\Resources\DeviceCounts\Pages\ListDeviceCounts;
use App\Filament\Resources\DeviceCounts\Schemas\DeviceCountForm;
use App\Filament\Resources\DeviceCounts\Tables\DeviceCountsTable;
use App\Models\DeviceCount;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class DeviceCountResource extends Resource
{
    protected static ?string $model = DeviceCount::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'DeviceCount';

    public static function canCreate(): bool
    {
        return Auth::user()?->role === UserRole::Admin;
    }

    public static function canEdit($record): bool
    {
        return Auth::user()?->role === UserRole::Admin;
    }

    public static function canDelete($record): bool
    {
        return Auth::user()?->role === UserRole::Admin;
    }

    public static function form(Schema $schema): Schema
    {
        return DeviceCountForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DeviceCountsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDeviceCounts::route('/'),
        ];
    }
}
