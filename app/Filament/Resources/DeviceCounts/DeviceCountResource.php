<?php

namespace App\Filament\Resources\DeviceCounts;

use App\Filament\Resources\DeviceCounts\Pages\CreateDeviceCount;
use App\Filament\Resources\DeviceCounts\Pages\EditDeviceCount;
use App\Filament\Resources\DeviceCounts\Pages\ListDeviceCounts;
use App\Filament\Resources\DeviceCounts\Schemas\DeviceCountForm;
use App\Filament\Resources\DeviceCounts\Tables\DeviceCountsTable;
use App\Models\DeviceCount;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DeviceCountResource extends Resource
{
    protected static ?string $model = DeviceCount::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'DeviceCount';

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
            'create' => CreateDeviceCount::route('/create'),
            'edit' => EditDeviceCount::route('/{record}/edit'),
        ];
    }
}
