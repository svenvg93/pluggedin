<?php

namespace App\Filament\Resources\DeviceTypes\Resources\DeviceModels;

use App\Filament\Resources\DeviceTypes\DeviceTypeResource;
use App\Filament\Resources\DeviceTypes\Resources\DeviceModels\Schemas\DeviceModelForm;
use App\Filament\Resources\DeviceTypes\Resources\DeviceModels\Tables\DeviceModelTable;
use App\Models\DeviceModel;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DeviceModelResource extends Resource
{
    protected static ?string $model = DeviceModel::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $parentResource = DeviceTypeResource::class;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return DeviceModelForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DeviceModelTable::configure($table);
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
        ];
    }
}
