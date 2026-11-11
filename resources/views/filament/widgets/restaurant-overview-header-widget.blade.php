<x-filament-widgets::widget class="dk-header-widget">
    <div style="background: linear-gradient(135deg, #18181b 0%, #27272a 50%, #09090b 100%); border: 1px solid rgba(249, 115, 22, 0.25); border-radius: 1.25rem; padding: 1.75rem 2rem; color: #ffffff; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.3); position: relative; overflow: hidden;">
        <!-- Top decorative warm glow -->
        <div style="position: absolute; top: -50px; right: -50px; width: 220px; height: 220px; border-radius: 9999px; background: radial-gradient(circle, rgba(249,115,22,0.2) 0%, transparent 70%); pointer-events: none;"></div>

        <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 1.5rem; position: relative; z-index: 2;">
            <!-- Left Info -->
            <div style="max-width: 680px;">
                <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.65rem; flex-wrap: wrap;">
                    <span style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 700; background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3);">
                        <span style="display: inline-block; width: 7px; height: 7px; border-radius: 9999px; background: #34d399;" class="dk-live-dot"></span>
                        Kitchen Live & Taking Orders
                    </span>
                    <span style="font-size: 0.8rem; color: #a1a1aa; font-weight: 500;">
                        📅 {{ $todayDate }}
                    </span>
                </div>

                <h1 style="font-size: 1.75rem; font-weight: 800; margin: 0 0 0.4rem 0; letter-spacing: -0.02em; color: #ffffff;">
                    {{ $greeting }}, {{ $name }}! {{ $greetingEmoji }}
                </h1>
                
                <p style="font-size: 0.875rem; color: #d4d4d8; margin: 0 0 1rem 0; line-height: 1.5;">
                    Welcome to <strong style="color: #fb923c;">DanishKada Executive Dashboard</strong>. Monitor orders, kitchen status, sales, and catalog in real-time.
                </p>

                <!-- Mini Badges -->
                <div style="display: flex; flex-wrap: wrap; gap: 0.75rem;">
                    <span style="display: inline-flex; align-items: center; gap: 0.35rem; padding: 0.35rem 0.85rem; border-radius: 0.65rem; background: rgba(39, 39, 42, 0.9); border: 1px solid #3f3f46; font-size: 0.78rem;">
                        <span style="color: #a1a1aa;">Active Kitchen:</span>
                        <strong style="color: #f59e0b;">{{ $activeOrders }} {{ Str::plural('Order', $activeOrders) }}</strong>
                    </span>

                    <span style="display: inline-flex; align-items: center; gap: 0.35rem; padding: 0.35rem 0.85rem; border-radius: 0.65rem; background: rgba(39, 39, 42, 0.9); border: 1px solid #3f3f46; font-size: 0.78rem;">
                        <span style="color: #a1a1aa;">Today's Revenue:</span>
                        <strong style="color: #34d399;">Rs. {{ number_format($todayRevenue, 0) }}</strong>
                    </span>

                    <span style="display: inline-flex; align-items: center; gap: 0.35rem; padding: 0.35rem 0.85rem; border-radius: 0.65rem; background: rgba(39, 39, 42, 0.9); border: 1px solid #3f3f46; font-size: 0.78rem;">
                        <span style="color: #a1a1aa;">Today's Orders:</span>
                        <strong style="color: #38bdf8;">{{ $todayOrdersCount }}</strong>
                    </span>

                    @if($pendingReviews > 0)
                        <span style="display: inline-flex; align-items: center; gap: 0.35rem; padding: 0.35rem 0.85rem; border-radius: 0.65rem; background: rgba(39, 39, 42, 0.9); border: 1px solid rgba(245, 158, 11, 0.3); font-size: 0.78rem;">
                            <span style="color: #a1a1aa;">Pending Reviews:</span>
                            <strong style="color: #f59e0b;">{{ $pendingReviews }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <!-- Right Quick Actions -->
            <div style="display: flex; flex-wrap: wrap; gap: 0.65rem;">
                <a href="{{ url('admin/orders/create') }}" style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.6rem 1.15rem; border-radius: 0.75rem; background: linear-gradient(135deg, #ea580c, #f59e0b); color: #ffffff; font-size: 0.85rem; font-weight: 700; text-decoration: none; box-shadow: 0 4px 14px rgba(234, 88, 12, 0.4); transition: transform 0.2s;">
                    <span>+ New Order</span>
                </a>

                <a href="{{ url('admin/products/create') }}" style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.6rem 1.15rem; border-radius: 0.75rem; background: #27272a; border: 1px solid #52525b; color: #f4f4f5; font-size: 0.85rem; font-weight: 600; text-decoration: none;">
                    <span>+ Add Dish</span>
                </a>

                <a href="{{ url('admin/orders') }}" style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.6rem 1.15rem; border-radius: 0.75rem; background: #27272a; border: 1px solid #3f3f46; color: #d4d4d8; font-size: 0.85rem; font-weight: 600; text-decoration: none;">
                    <span>View Orders</span>
                </a>
            </div>
        </div>
    </div>
</x-filament-widgets::widget>
