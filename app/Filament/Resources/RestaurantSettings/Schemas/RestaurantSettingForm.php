<?php

namespace App\Filament\Resources\RestaurantSettings\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class RestaurantSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('key')
                    ->required(),
                Textarea::make('value')
                    ->columnSpanFull(),
            ]);
    }
}
