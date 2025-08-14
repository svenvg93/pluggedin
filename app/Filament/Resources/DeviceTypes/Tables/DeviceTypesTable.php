<?php

namespace App\Filament\Resources\DeviceTypes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ActionGroup;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DeviceTypesTable
{
    public static function configure(Table $table): Table
    {
        return $table
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
