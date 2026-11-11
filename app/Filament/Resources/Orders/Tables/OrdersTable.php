<?php

namespace App\Filament\Resources\Orders\Tables;

use App\Models\Order;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_number')
                    ->label('Order #')
                    ->searchable()
                    ->weight('bold')
                    ->copyable()
                    ->icon(Heroicon::OutlinedShoppingBag),

                TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable()
                    ->default('Direct Customer')
                    ->description(fn (Order $record) => $record->user?->email ?? $record->address?->phone ?? 'Walk-in / Direct')
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
                    ->label('Status')
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

                TextColumn::make('total')
                    ->label('Total (PKR)')
                    ->formatStateUsing(fn ($state) => 'Rs. ' . number_format($state, 0))
                    ->weight('bold')
                    ->color('primary')
                    ->sortable(),

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

                TextColumn::make('created_at')
                    ->label('Order Placed')
                    ->dateTime('d M Y, h:i A')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending Confirmation',
                        'confirmed' => 'Confirmed',
                        'preparing' => 'In Kitchen (Preparing)',
                        'ready' => 'Ready for Pickup / Dispatch',
                        'out_for_delivery' => 'Out for Delivery',
                        'delivered' => 'Delivered',
                        'cancelled' => 'Cancelled',
                    ]),

                SelectFilter::make('type')
                    ->options([
                        'delivery' => 'Delivery',
                        'pickup' => 'Takeaway',
                    ]),

                SelectFilter::make('payment_status')
                    ->options([
                        'paid' => 'Paid',
                        'pending' => 'Pending',
                        'failed' => 'Failed',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
