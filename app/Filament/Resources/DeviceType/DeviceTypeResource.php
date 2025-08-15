<?php

namespace App\Filament\Resources\DeviceType;

use App\Enums\UserRole;
use App\Filament\Resources\DeviceType\Pages\CreateDeviceType;
use App\Filament\Resources\DeviceType\Pages\EditDeviceType;
use App\Filament\Resources\DeviceType\Pages\ListDeviceTypes;
use App\Filament\Resources\DeviceType\Schemas\DeviceTypesForm;
use App\Filament\Resources\DeviceType\RelationManagers\DeviceModelsRelationManager;
use App\Filament\Resources\DeviceType\Tables\DeviceTypesTable;
use App\Models\DeviceType;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class DeviceTypeResource extends Resource
{
    protected static ?string $model = DeviceType::class;

    protected static ?string $slug = 'device-types';

    protected static ?string $navigationLabel = 'Device Types';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::CircleStack;

    protected static string|\UnitEnum|null $navigationGroup = 'Data';

    public static function canAccess(): bool
    {
        return Auth::user()?->role === UserRole::Admin;
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()?->role === UserRole::Admin;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components(DeviceTypesForm::schema());
    }

    public static function table(Table $table): Table
    {
        return DeviceTypesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            'deviceModels' => DeviceModelsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDeviceTypes::route('/'),
            'create' => CreateDeviceType::route('/create'),
            'edit' => EditDeviceType::route('/{record}/edit'),
        ];
    }
}
