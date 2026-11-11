<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;

class OrderStatusChartWidget extends ChartWidget
{
    protected static ?int $sort = 4;

    protected static bool $isLazy = false;

    protected int | string | array $columnSpan = [
        'md' => 1,
        'xl' => 1,
    ];

    protected ?string $maxHeight = '300px';

    protected ?string $heading = 'Order Status Distribution';

    protected ?string $description = 'Proportion of fulfilled vs active orders';

    protected function getData(): array
    {
        $delivered = Order::where('status', 'delivered')->count();
        $preparing = Order::whereIn('status', ['confirmed', 'preparing', 'ready'])->count();
        $pending = Order::where('status', 'pending')->count();
        $outForDelivery = Order::where('status', 'out_for_delivery')->count();
        $cancelled = Order::where('status', 'cancelled')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Total Orders',
                    'data' => [$delivered, $preparing, $pending, $outForDelivery, $cancelled],
                    'backgroundColor' => [
                        '#10B981', // Delivered (Emerald)
                        '#3B82F6', // Preparing (Blue)
                        '#F59E0B', // Pending (Amber)
                        '#8B5CF6', // Out for delivery (Purple)
                        '#EF4444', // Cancelled (Rose)
                    ],
                    'borderWidth' => 2,
                    'borderColor' => '#18181B',
                    'hoverOffset' => 6,
                ],
            ],
            'labels' => ['Delivered', 'Preparing', 'Pending', 'Out for Delivery', 'Cancelled'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                    'labels' => [
                        'boxWidth' => 12,
                        'padding' => 15,
                    ],
                ],
            ],
            'cutout' => '68%',
        ];
    }
}
