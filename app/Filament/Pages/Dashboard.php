<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\DeviceModelLineChartWidget;
use App\Filament\Widgets\DeviceTypeStatsWidget;
use App\Models\DeviceCount;
use App\Models\DeviceModel;
use App\Models\DeviceType;
use App\Forms\Components\DateFilterForm;
use BackedEnum;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Dashboard as BaseDashboard;
use Illuminate\Support\Facades\Auth;


class Dashboard extends BaseDashboard
{
    use HasFiltersForm;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar';

    public function getSubheading(): ?string
    {
        $lastUpdate = DeviceCount::orderByDesc('recorded_at')->value('recorded_at');

        if (! $lastUpdate) {
            return 'No device count updates yet.';
        }

        $formattedDate = Carbon::parse($lastUpdate)->format(config('app.datetime_format'));

        return 'Last updated on: '.$formattedDate;
    }


    public function filtersForm(Schema $schema): Schema
    {
        return DateFilterForm::make($schema);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('registerDevice')
                ->form([
                    Select::make('model_id')
                        ->label('Device Model')
                        ->options(
                            DeviceModel::with('deviceType')
                                ->get()
                                ->mapWithKeys(function ($model) {
                                    $vendorName = $model->vendor;
                                    $displayName = $vendorName ? "{$vendorName} {$model->name}" : $model->name;
                                    return [$model->id => "{$displayName}"];
                                })
                                ->toArray()
                        )
                        ->searchable()
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $set) {
                            if ($state) {
                                $deviceModel = DeviceModel::with('deviceType')->find($state);
                                $set('device_type', $deviceModel->deviceType->name);
                            }
                        }),
                    TextInput::make('count')
                        ->label('Amount')
                        ->helpertext('Please enter the amount without any dots or commas. Only count devices that are online in the ACS!')
                        ->numeric()
                        ->required(),
                    TextInput::make('device_type')
                        ->label('Device Type')
                        ->helpertext('Automatically filled based on the Device Model.')
                        ->readonly(),
                    DatePicker::make('recorded_at')
                        ->label('Record Date')
                        ->native(false)
                        ->default(now()->toDateString()),
                    Textarea::make('comment')
                        ->label('Comment'),
                ])
                ->action(function (array $data) {
                    DeviceCount::create([
                        'model_id' => $data['model_id'],
                        'recorded_at' => $data['recorded_at'],
                        'count' => $data['count'],
                        'comment' => $data['comment'] ?? null,
                    ]);
                    Notification::make()
                        ->title('Device amount added successfully')
                        ->success()
                        ->send();
                })
                ->modalHeading('Add New Device Amount')
                ->modalWidth('lg')
                ->modalSubmitActionLabel('Add')
                ->button()
                ->color('primary')
                ->label('Add Device Amount')
                ->icon('heroicon-c-document-arrow-up')
                ->iconPosition('before')
                ->hidden(! Auth::user()->is_admin),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            DeviceTypeStatsWidget::class,
        ];
    }

    public function getWidgets(): array
    {
        // Fetch all device types
        $deviceTypes = DeviceType::all();

        $widgets = [];
        foreach ($deviceTypes as $deviceType) {
            // Create a widget for each device type and pass relevant parameters
            $widget = DeviceModelLineChartWidget::make([
                'deviceType' => $deviceType,
            ]);

            $widgets[] = $widget;
        }

        return $widgets;
    }
}
