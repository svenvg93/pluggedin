<?php

namespace App\Filament\Resources\DeviceTypes;

use App\Enums\UserRole;
use App\Filament\Resources\DeviceTypes\Pages;
use App\Filament\Resources\DeviceTypes\Pages\ListDeviceTypes;
use App\Filament\Resources\DeviceTypes\Schemas\DeviceTypesForm;
use App\Filament\Resources\DeviceTypes\Tables\DeviceTypesTable;
use App\Models\DeviceTypes;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class DeviceTypesResource extends Resource
{
    protected static ?string $model = DeviceTypes::class;

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

    public static function getPages(): array
    {
        return [
            'index' => ListDeviceTypes::route('/'),
        ];
    }
}
