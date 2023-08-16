<?php

namespace App\Http\Controllers\Concerns;

use App\Services\ApexChart;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Database\Eloquent\Builder;

trait ChartData
{
    private function getChartData(Builder $query, string $interval, string $label, string $seriesName = null): array
    {
        $data = Trend::query($query)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->interval($interval)
            ->count();

        return ApexChart::make('line')
            ->setWidth('100%')
            ->setHeight(500)
            ->setLabels($data->map(fn (TrendValue $value) => $interval === 'month' ? toMonthName($value->date) : $value->date))
            ->setDataset($label, $data->map(fn (TrendValue $value) => $value->aggregate))
            ->render();
    }
}
