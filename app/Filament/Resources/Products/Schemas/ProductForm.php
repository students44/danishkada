<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('category_id')
                    ->required()
                    ->numeric(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('discount_price')
                    ->numeric()
                    ->prefix('$'),
                FileUpload::make('image')
                    ->image(),
                TextInput::make('sku')
                    ->label('SKU'),
                Toggle::make('status')
                    ->required(),
                Toggle::make('is_featured')
                    ->required(),
                Toggle::make('is_popular')
                    ->required(),
                Textarea::make('ingredients')
                    ->columnSpanFull(),
            ]);
    }
}
