<?php

namespace App\Filament\Resources\RestaurantSettings\Pages;

use App\Filament\Resources\RestaurantSettings\RestaurantSettingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRestaurantSettings extends ListRecords
{
    protected static string $resource = RestaurantSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
