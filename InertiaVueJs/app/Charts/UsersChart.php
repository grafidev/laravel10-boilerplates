<?php

namespace App\Charts;

use App\Repositories\UserRepository;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class UsersChart
{
    public function __construct(protected LarapexChart $chart, protected UserRepository $userRepository)
    {
    }

    public function build($interval = 'month')
    {
        $data = Trend::query(
            $this->userRepository->query()
        )
            ->between(start: now()->startOfYear(), end: now()->endOfYear())
            ->interval($interval)
            ->count();

        return $this->chart->areaChart()
            ->setTitle($this->chartTitle($interval))
            ->addData('Utilisateurs', $data->map(fn (TrendValue $value) => $value->aggregate)->toArray())
            ->setGrid()
            ->setToolbar(true)
            ->setXAxis($data->map(fn (TrendValue $value) => $interval === 'month' ? toMonthName($value->date) : $value->date)->toArray())
            ->toVue();
    }

    private function chartTitle($interval)
    {
        return match (true) {
            $interval === 'day' => 'Utilisateurs par jour',
            $interval === 'month' => 'Utilisateurs par mois',
            $interval === 'year' => 'Utilisateurs par année',
            default => 'Utilisateurs'
        };
    }
}
