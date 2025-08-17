<?php

namespace App\Filament\Resources\DeviceCounts\Tables;

use App\Enums\UserRole;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use App\Filament\Exports\DeviceCountExporter;
use Filament\Actions\ExportAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class DeviceCountsTable
{
    public static function configure(Table $table): Table
    {
        $isAdmin = Auth::user()?->role === UserRole::Admin;

        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID'),
                TextColumn::make('deviceModel.vendor')
                    ->label('Vendor')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('deviceModel.name')
                    ->label('Device Model')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('recorded_at')
                    ->date()
                    ->sortable(),
                TextColumn::make('count')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('comment')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                ExportAction::make()
                    ->exporter(DeviceCountExporter::class)
                    ->visible(fn (): bool => $isAdmin),
            ])
            ->recordActions([
                ActionGroup::make([
                    EditAction::make()
                        ->visible(fn (): bool => $isAdmin),
                    DeleteAction::make()
                        ->visible(fn (): bool => $isAdmin),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->visible(fn (): bool => $isAdmin),
                ]),
            ]);
    }
}
