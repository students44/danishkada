<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\RestaurantSetting;
use App\Models\Review;
use Carbon\Carbon;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class RestaurantOverviewHeaderWidget extends Widget
{
    protected static ?int $sort = 1;

    protected static bool $isLazy = false;

    protected int | string | array $columnSpan = 'full';

    protected string $view = 'filament.widgets.restaurant-overview-header-widget';

    public function getViewData(): array
    {
        $user = Auth::user();
        $name = $user ? explode(' ', $user->name)[0] : 'Admin';

        $hour = Carbon::now()->hour;
        if ($hour < 12) {
            $greeting = 'Good Morning';
            $greetingEmoji = '☀️';
        } elseif ($hour < 17) {
            $greeting = 'Good Afternoon';
            $greetingEmoji = '🌤️';
        } else {
            $greeting = 'Good Evening';
            $greetingEmoji = '🌙';
        }

        $isOpen = RestaurantSetting::where('key', 'is_open')->value('value') !== '0';
        $kitchenStatus = RestaurantSetting::where('key', 'kitchen_status')->value('value') ?? 'active';

        $activeOrders = Order::whereIn('status', ['pending', 'confirmed', 'preparing', 'out_for_delivery'])->count();
        $todayRevenue = Order::whereDate('created_at', Carbon::today())->where('status', '!=', 'cancelled')->sum('total');
        $todayOrdersCount = Order::whereDate('created_at', Carbon::today())->count();
        $pendingReviews = Review::where('status', 'pending')->count();

        return [
            'name' => $name,
            'greeting' => $greeting,
            'greetingEmoji' => $greetingEmoji,
            'isOpen' => $isOpen,
            'kitchenStatus' => $kitchenStatus,
            'activeOrders' => $activeOrders,
            'todayRevenue' => $todayRevenue,
            'todayOrdersCount' => $todayOrdersCount,
            'pendingReviews' => $pendingReviews,
            'todayDate' => Carbon::now()->format('l, d F Y'),
        ];
    }
}
