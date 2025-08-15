<?php

namespace App\Filament\Resources\DeviceTypes;

use App\Enums\UserRole;
use App\Filament\Resources\DeviceTypes\Pages\CreateDeviceType;
use App\Filament\Resources\DeviceTypes\Pages\EditDeviceType;
use App\Filament\Resources\DeviceTypes\Pages\ListDeviceTypes;
use App\Filament\Resources\DeviceTypes\Schemas\DeviceTypesForm;
use App\Filament\Resources\DeviceTypes\RelationManagers\DeviceModelsRelationManager;
use App\Filament\Resources\DeviceTypes\Tables\DeviceTypesTable;
use App\Models\DeviceType;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class DeviceTypesResource extends Resource
{
    protected static ?string $model = DeviceType::class;

    protected static ?string $navigationLabel = 'Devices';

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
