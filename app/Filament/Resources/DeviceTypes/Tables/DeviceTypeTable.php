<?php

namespace App\Filament\Resources\DeviceTypes\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DeviceTypeTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->description('To manage device models, open the device type they belong to. When you edit a device type, you’ll see a table of its models where you can add, edit, or delete them.')
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                TextColumn::make('name')
                    ->sortable()
                    ->toggleable()
                    ->label('Type'),
                ColorColumn::make('color')
                    ->label('Color')
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('comment')
                    ->label('Comment')
                    ->toggleable()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'asc')
            ->recordActions([
                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
