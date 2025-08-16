<?php

namespace App\Filament\Widgets;

use App\Models\DeviceCount;
use App\Models\DeviceType;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Illuminate\Database\Eloquent\Builder;
use Filament\Pages\Dashboard\Concerns\HasFilters;
use Illuminate\Support\Facades\Log;

class DeviceModelLineChartWidget extends ChartWidget
{
    use HasFilters;

    public function getHeading(): ?string
    {
        return $this->deviceType ? "{$this->deviceType->name}" : '';
    }

    public function getDescription(): string
    {
        return $this->deviceType?->comment ?: '';
    }

    protected int|string|array $columnSpan = 'full';

    protected ?string $maxHeight = '250px';

    protected function getPollingInterval(): ?string
    {
        return '1s';
    }

    public function getFiltersFormData(): array
    {
        return $this->getFilters();
    }

    protected function getListeners(): array
    {
        return [
            'refreshComponent',
        ];
    }

    public function refreshComponent(): void
    {
        $this->dispatch('refresh');
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
            return [];
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
        
        Log::info('Using date range from session:', [
            'startDate' => $startDate->format('Y-m-d H:i:s'),
            'endDate' => $endDate->format('Y-m-d H:i:s'),
        ]);

        $deviceModels = $this->deviceType->deviceModels;

        $deviceAmounts = DeviceCount::query()
            ->whereHas('deviceModel', function (Builder $query) {
                $query->where('type_id', $this->deviceType->id);
            })
            ->when($startDate, fn (Builder $query) => $query->where('recorded_at', '>=', $startDate->startOfDay()))
            ->when($endDate, fn (Builder $query) => $query->where('recorded_at', '<=', $endDate->endOfDay()))
            ->get();

        // Pre-format date labels to 'Y-m-d' for indexing and map for the chart
        $rawLabels = $deviceAmounts->pluck('recorded_at')
            ->filter()
            ->map(fn ($date) => Carbon::parse($date)->format('Y-m-d'))
            ->unique()
            ->sort()
            ->values();

        // Final formatted labels for the chart display
        $labels = $rawLabels->map(fn ($raw) => Carbon::parse($raw)
            ->timezone(config('app.display_timezone'))
            ->format(config('app.chart_datetime_format'))
        )->toArray();

        // Group by device model and date for fast lookup
        $groupedAmounts = $deviceAmounts->groupBy([
            'deviceModel.name',
            fn ($item) => Carbon::parse($item->recorded_at)->format('Y-m-d'),
        ]);

        $deviceColors = $deviceModels->pluck('color', 'name')->toArray();

        $datasets = $deviceModels->map(function ($model) use ($rawLabels, $groupedAmounts, $deviceColors) {
            $modelName = $model->name;
            $vendorName = $model->vendor;
            
            // Create label with vendor and model name
            $label = $vendorName ? "{$vendorName} {$modelName}" : $modelName;

            $data = $rawLabels->map(fn ($date) => optional($groupedAmounts[$modelName][$date] ?? null)[0]->count ?? null
            )->toArray();

            return [
                'label' => $label,
                'data' => $data,
                'borderColor' => $deviceColors[$modelName] ?? '#000000',
                'backgroundColor' => $deviceColors[$modelName] ?? '#000000',
                'pointBackgroundColor' => $deviceColors[$modelName] ?? '#000000',
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
