<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->numeric(),
                TextInput::make('address_id')
                    ->numeric(),
                TextInput::make('order_number')
                    ->required(),
                Select::make('type')
                    ->options(['delivery' => 'Delivery', 'pickup' => 'Pickup'])
                    ->default('delivery')
                    ->required(),
                Select::make('status')
                    ->options([
            'pending' => 'Pending',
            'confirmed' => 'Confirmed',
            'preparing' => 'Preparing',
            'ready' => 'Ready',
            'out_for_delivery' => 'Out for delivery',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled',
        ])
                    ->default('pending')
                    ->required(),
                TextInput::make('subtotal')
                    ->required()
                    ->numeric(),
                TextInput::make('delivery_fee')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('discount')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('tax')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('total')
                    ->required()
                    ->numeric(),
                TextInput::make('payment_method')
                    ->required()
                    ->default('cod'),
                Select::make('payment_status')
                    ->options(['pending' => 'Pending', 'paid' => 'Paid', 'failed' => 'Failed'])
                    ->default('pending')
                    ->required(),
                Textarea::make('delivery_instructions')
                    ->columnSpanFull(),
            ]);
    }
}
