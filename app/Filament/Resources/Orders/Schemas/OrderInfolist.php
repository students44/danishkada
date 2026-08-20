<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class OrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('address_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('order_number'),
                TextEntry::make('type')
                    ->badge(),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('subtotal')
                    ->numeric(),
                TextEntry::make('delivery_fee')
                    ->numeric(),
                TextEntry::make('discount')
                    ->numeric(),
                TextEntry::make('tax')
                    ->numeric(),
                TextEntry::make('total')
                    ->numeric(),
                TextEntry::make('payment_method'),
                TextEntry::make('payment_status')
                    ->badge(),
                TextEntry::make('delivery_instructions')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
