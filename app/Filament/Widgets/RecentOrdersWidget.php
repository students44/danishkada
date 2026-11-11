<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentOrdersWidget extends TableWidget
{
    protected static ?int $sort = 5;

    protected static bool $isLazy = false;

    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = 'Recent Kitchen & Delivery Orders';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Order::query()->with(['user', 'address'])->latest())
            ->columns([
                TextColumn::make('order_number')
                    ->label('Order #')
                    ->searchable()
                    ->weight('bold')
                    ->copyable()
                    ->icon(Heroicon::OutlinedShoppingBag),

                TextColumn::make('user.name')
                    ->label('Customer')
                    ->default('Direct Customer')
                    ->description(fn (Order $record) => $record->user?->email ?? $record->address?->phone ?? 'Walk-in / Phone')
                    ->icon(Heroicon::OutlinedUser),

                TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'delivery' => '🛵 Delivery',
                        'pickup' => '🛍️ Takeaway',
                        default => ucfirst($state),
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'delivery' => 'primary',
                        'pickup' => 'success',
                        default => 'gray',
                    }),

                TextColumn::make('status')
                    ->label('Kitchen Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => ucfirst(str_replace('_', ' ', $state)))
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'confirmed' => 'info',
                        'preparing' => 'primary',
                        'ready' => 'success',
                        'out_for_delivery' => 'info',
                        'delivered' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('payment_status')
                    ->label('Payment')
                    ->badge()
                    ->description(fn (Order $record) => $record->payment_method)
                    ->color(fn (string $state): string => match ($state) {
                        'paid' => 'success',
                        'pending' => 'warning',
                        'failed' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('total')
                    ->label('Total (PKR)')
                    ->formatStateUsing(fn ($state) => 'Rs. ' . number_format($state, 0))
                    ->weight('bold')
                    ->color('primary'),

                TextColumn::make('created_at')
                    ->label('Placed')
                    ->since()
                    ->color('gray'),
            ])
            ->recordActions([
                Action::make('view')
                    ->label('View Details')
                    ->icon(Heroicon::OutlinedEye)
                    ->url(fn (Order $record): string => url("admin/orders/{$record->id}")),
            ])
            ->paginated([5, 10, 25])
            ->defaultPaginationPageOption(5);
    }
}
