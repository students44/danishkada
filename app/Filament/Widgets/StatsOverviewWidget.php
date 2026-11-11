<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Review;
use App\Models\User;
use Carbon\Carbon;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget as BaseStatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseStatsOverviewWidget
{
    protected static ?int $sort = 2;

    protected static bool $isLazy = false;

    protected function getStats(): array
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        // 1. Revenue calculations
        $todayRevenue = Order::whereDate('created_at', $today)
            ->where('status', '!=', 'cancelled')
            ->sum('total');

        $yesterdayRevenue = Order::whereDate('created_at', $yesterday)
            ->where('status', '!=', 'cancelled')
            ->sum('total');

        $revenueChange = $yesterdayRevenue > 0
            ? round((($todayRevenue - $yesterdayRevenue) / $yesterdayRevenue) * 100, 1)
            : ($todayRevenue > 0 ? 100 : 0);

        // 7-day revenue sparkline
        $sevenDayRevenue = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $daySum = Order::whereDate('created_at', $date)
                ->where('status', '!=', 'cancelled')
                ->sum('total');
            $sevenDayRevenue[] = (float) $daySum;
        }

        // 2. Active Kitchen Orders
        $pendingCount = Order::where('status', 'pending')->count();
        $preparingCount = Order::whereIn('status', ['confirmed', 'preparing', 'ready'])->count();
        $outCount = Order::where('status', 'out_for_delivery')->count();
        $activeOrders = $pendingCount + $preparingCount + $outCount;

        // 7-day order count sparkline
        $sevenDayOrders = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $dayCount = Order::whereDate('created_at', $date)->count();
            $sevenDayOrders[] = (float) $dayCount;
        }

        // 3. Delivered orders & AOV
        $deliveredOrders = Order::where('status', 'delivered')->count();
        $deliveredRevenue = Order::where('status', 'delivered')->sum('total');
        $aov = $deliveredOrders > 0 ? round($deliveredRevenue / $deliveredOrders, 0) : 0;

        // 4. Customers & Ratings
        $totalCustomers = User::count();
        $avgRating = Review::where('status', 'approved')->avg('rating') ?? 5.0;
        $formattedRating = number_format($avgRating, 1);

        return [
            Stat::make("Today's Gross Sales", 'Rs. ' . number_format($todayRevenue, 0))
                ->description($revenueChange >= 0 ? "+{$revenueChange}% vs yesterday" : "{$revenueChange}% vs yesterday")
                ->descriptionIcon($revenueChange >= 0 ? Heroicon::OutlinedArrowTrendingUp : Heroicon::OutlinedArrowTrendingDown)
                ->color($revenueChange >= 0 ? 'success' : 'danger')
                ->chart($sevenDayRevenue)
                ->url(url('admin/orders')),

            Stat::make('Active Kitchen Orders', (string) $activeOrders)
                ->description("{$pendingCount} pending • {$preparingCount} cooking • {$outCount} on way")
                ->descriptionIcon(Heroicon::OutlinedClock)
                ->color($activeOrders > 0 ? 'warning' : 'gray')
                ->chart($sevenDayOrders)
                ->url(url('admin/orders')),

            Stat::make('Average Order Value (AOV)', 'Rs. ' . number_format($aov, 0))
                ->description("Across {$deliveredOrders} fulfilled orders")
                ->descriptionIcon(Heroicon::OutlinedReceiptPercent)
                ->color('info')
                ->url(url('admin/orders')),

            Stat::make('Customer Satisfaction', "★ {$formattedRating} / 5.0")
                ->description("{$totalCustomers} registered diners • " . Review::count() . " reviews")
                ->descriptionIcon(Heroicon::OutlinedStar)
                ->color('primary')
                ->url(url('admin/reviews')),
        ];
    }
}
