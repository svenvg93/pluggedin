<?php

namespace App\Filament\Widgets;

use App\Models\DeviceType;
use Carbon\Carbon;
use Filament\Pages\Dashboard\Concerns\HasFilters;
use Filament\Widgets\ChartWidget;

class DeviceModelLineChartWidget extends ChartWidget
{
    use HasFilters;

    public function getHeading(): ?string
    {
        return $this->deviceType ? "{$this->deviceType->name}" : '';
    }

    public function getDescription(): ?string
    {
        return $this->deviceType?->comment;
    }

    protected int|string|array $columnSpan = 'full';

    protected ?string $maxHeight = '250px';

    protected function getPollingInterval(): ?string
    {
        return '60s';
    }

    public function getFiltersFormData(): array
    {
        return $this->getFilters();
    }

    public ?DeviceType $deviceType = null;

    // Method to create multiple widgets for each device type
    public static function getWidgets(): array
    {
        $deviceTypes = DeviceType::all();
        $widgets = [];

        foreach ($deviceTypes as $deviceType) {
            $widget = static::make([
                'deviceType' => $deviceType,
            ]);

            $widgets[] = $widget;
        }

        return $widgets;
    }

    // Fluent setter method for device type
    public function deviceType(DeviceType $type): static
    {
        $this->deviceType = $type;

        return $this;
    }

    protected function getData(): array
    {
        if (! $this->deviceType) {
            return ['datasets' => [], 'labels' => []];
        }

        // Get filter values from session (much more reliable in Filament v4)
        $startDate = session('dashboard_start_date') ?? now()->subWeek()->timezone(config('app.display_timezone'));
        $endDate = session('dashboard_end_date') ?? now()->timezone(config('app.display_timezone'));

        // Convert string dates to Carbon instances if needed
        if (is_string($startDate)) {
            $startDate = Carbon::parse($startDate)->timezone(config('app.display_timezone'));
        }
        if (is_string($endDate)) {
            $endDate = Carbon::parse($endDate)->timezone(config('app.display_timezone'));
        }

        // Eager load models with their counts in one query
        $deviceModels = $this->deviceType->deviceModels()
            ->with(['deviceCounts' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('recorded_at', [
                    $startDate->startOfDay(),
                    $endDate->endOfDay(),
                ])->orderBy('recorded_at');
            }])
            ->get();

        if ($deviceModels->isEmpty()) {
            return ['datasets' => [], 'labels' => []];
        }

        // Collect all unique dates from all device counts
        $allDates = collect();
        foreach ($deviceModels as $model) {
            $allDates = $allDates->merge(
                $model->deviceCounts->pluck('recorded_at')->map(fn ($date) => $date->format('Y-m-d'))
            );
        }

        $rawLabels = $allDates->unique()->sort()->values();

        // Final formatted labels for the chart display
        $labels = $rawLabels->map(fn ($raw) => Carbon::parse($raw)
            ->timezone(config('app.display_timezone'))
            ->format(config('app.chart_datetime_format'))
        )->toArray();

        $datasets = $deviceModels->map(function ($model) use ($rawLabels) {
            // Build a lookup map for this model's counts
            $countsMap = $model->deviceCounts->keyBy(fn ($count) => $count->recorded_at->format('Y-m-d')
            );

            $label = $model->vendor ? "{$model->vendor} {$model->name}" : $model->name;

            $data = $rawLabels->map(fn ($date) => $countsMap->get($date)?->count
            )->toArray();

            return [
                'label' => $label,
                'data' => $data,
                'borderColor' => $model->color ?? '#000000',
                'backgroundColor' => $model->color ?? '#000000',
                'pointBackgroundColor' => $model->color ?? '#000000',
                'fill' => false,
                'cubicInterpolationMode' => 'monotone',
                'tension' => 0.4,
            ];
        })->values()->toArray();

        return [
            'datasets' => $datasets,
            'labels' => $labels,
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                ],
                'tooltip' => [
                    'enabled' => true,
                    'mode' => 'index',
                    'intersect' => false,
                    'position' => 'nearest',
                ],
            ],
            'scales' => [
                'x' => [
                    'title' => [
                        'display' => true,
                        'text' => 'Date',
                    ],
                ],
                'y' => [
                    'beginAtZero' => false,
                    'title' => [
                        'display' => true,
                        'text' => 'Amount',
                    ],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
