<?php

namespace App\Forms\Components;

use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DateFilterForm
{
    public static function make(Schema $schema): Schema
    {
        // Calculate the start and end dates based on the configuration value
        $defaultEndDate = now(); // Today
        $defaultStartDate = now()->subDays(120); // Start date for the range

        return $schema
            ->schema([
                Section::make()
                    ->schema([
                        DatePicker::make('startDate')
                            ->label('Start Date')
                            ->default($defaultStartDate->startOfDay())
                            ->reactive()
                            ->seconds(false)
                            ->native(false)
                            ->live()
                            ->afterStateUpdated(function ($state) {
                                if ($state) {
                                    session(['dashboard_start_date' => $state]);
                                }
                            }),
                        DatePicker::make('endDate')
                            ->label('End Date')
                            ->default($defaultEndDate->endOfDay())
                            ->reactive()
                            ->seconds(false)
                            ->native(false)
                            ->live()
                            ->afterStateUpdated(function ($state) {
                                if ($state) {
                                    session(['dashboard_end_date' => $state]);
                                }
                            }),
                    ])
                    ->columnSpanFull()
                    ->columns([
                        'default' => 1,
                        'sm' => 2,
                    ]),
            ]);
    }
}
