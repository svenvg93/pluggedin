<?php

namespace App\Filament\Widgets;

use App\Models\DeviceType;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DeviceTypeStatsWidget extends BaseWidget
{
    protected ?string $pollingInterval = '10s';

    protected static bool $isLazy = false;

    protected static bool $isHeaderWidget = true;

    protected function getCards(): array
    {
        $deviceTypes = DeviceType::with(['deviceModels.deviceCounts'])->get();

        $stats = [];
        $totalCurrent = 0;
        $totalPrevious = 0;

        foreach ($deviceTypes as $deviceType) {
            $currentSum = 0;
            $previousSum = 0;

            foreach ($deviceType->deviceModels as $deviceModel) {
                $latest = $deviceModel->deviceCounts()
                    ->orderByDesc('recorded_at')
                    ->first();

                if ($latest) {
                    $currentSum += $latest->count;

                    $previous = $deviceModel->deviceCounts()
                        ->where('recorded_at', '<', $latest->recorded_at)
                        ->orderByDesc('recorded_at')
                        ->first();

                    if ($previous) {
                        $previousSum += $previous->count;
                    }
                }
            }

            $diff = $currentSum - $previousSum;
            $pct = $previousSum > 0 ? round(($diff / $previousSum) * 100, 2) : null;

            $stats[] = Stat::make(ucfirst($deviceType->name), $currentSum)
                ->description($pct !== null
                    ? ($diff >= 0 ? "+{$pct}%" : "{$pct}%").' from previous'
                    : 'No previous data')
                ->descriptionIcon($diff >= 0
                    ? 'heroicon-m-arrow-trending-up'
                    : 'heroicon-m-arrow-trending-down')
                ->color($diff >= 0 ? 'success' : 'danger');

            $totalCurrent += $currentSum;
            $totalPrevious += $previousSum;
        }

        // Add total devices stat
        $totalDiff = $totalCurrent - $totalPrevious;
        $totalPct = $totalPrevious > 0 ? round(($totalDiff / $totalPrevious) * 100, 2) : null;

        array_unshift($stats, Stat::make('Total Devices', $totalCurrent)
            ->description($totalPct !== null
                ? ($totalDiff >= 0 ? "+{$totalPct}%" : "{$totalPct}%").' from previous'
                : 'No previous data')
            ->descriptionIcon($totalDiff >= 0
                ? 'heroicon-m-arrow-trending-up'
                : 'heroicon-m-arrow-trending-down')
            ->color($totalDiff >= 0 ? 'success' : 'danger')
        );

        return $stats;
    }
}
