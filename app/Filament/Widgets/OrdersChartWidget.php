<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class OrdersChartWidget extends ChartWidget
{
    protected static ?int $sort = 3;

    protected static bool $isLazy = false;

    protected int | string | array $columnSpan = [
        'md' => 1,
        'xl' => 2,
    ];

    protected ?string $maxHeight = '300px';

    protected ?string $heading = '14-Day Revenue & Sales Volume';

    protected ?string $description = 'Daily restaurant sales performance (PKR)';

    protected function getData(): array
    {
        $days = 14;
        $labels = [];
        $revenueData = [];
        $ordersCountData = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $labels[] = $date->format('M d');

            $revenue = Order::whereDate('created_at', $date)
                ->where('status', '!=', 'cancelled')
                ->sum('total');

            $count = Order::whereDate('created_at', $date)->count();

            $revenueData[] = (float) $revenue;
            $ordersCountData[] = $count;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Daily Revenue (Rs.)',
                    'data' => $revenueData,
                    'borderColor' => '#F97316',
                    'backgroundColor' => 'rgba(249, 115, 22, 0.12)',
                    'fill' => true,
                    'tension' => 0.4,
                    'borderWidth' => 3,
                    'pointBackgroundColor' => '#F97316',
                    'pointRadius' => 3,
                    'pointHoverRadius' => 6,
                    'yAxisID' => 'y',
                ],
                [
                    'label' => 'Orders Count',
                    'data' => $ordersCountData,
                    'borderColor' => '#06B6D4',
                    'backgroundColor' => 'rgba(6, 182, 212, 0.1)',
                    'fill' => false,
                    'tension' => 0.4,
                    'borderWidth' => 2,
                    'borderDash' => [5, 5],
                    'pointBackgroundColor' => '#06B6D4',
                    'pointRadius' => 3,
                    'pointHoverRadius' => 5,
                    'yAxisID' => 'y1',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'top',
                ],
            ],
            'scales' => [
                'y' => [
                    'type' => 'linear',
                    'display' => true,
                    'position' => 'left',
                    'title' => [
                        'display' => true,
                        'text' => 'Revenue (Rs.)',
                    ],
                ],
                'y1' => [
                    'type' => 'linear',
                    'display' => true,
                    'position' => 'right',
                    'grid' => [
                        'drawOnChartArea' => false,
                    ],
                    'title' => [
                        'display' => true,
                        'text' => 'Total Orders',
                    ],
                ],
            ],
        ];
    }
}
