<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('category_id')
                    ->numeric(),
                TextEntry::make('name'),
                TextEntry::make('slug'),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('price')
                    ->money(),
                TextEntry::make('discount_price')
                    ->money()
                    ->placeholder('-'),
                ImageEntry::make('image')
                    ->placeholder('-'),
                TextEntry::make('sku')
                    ->label('SKU')
                    ->placeholder('-'),
                IconEntry::make('status')
                    ->boolean(),
                IconEntry::make('is_featured')
                    ->boolean(),
                IconEntry::make('is_popular')
                    ->boolean(),
                TextEntry::make('ingredients')
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
