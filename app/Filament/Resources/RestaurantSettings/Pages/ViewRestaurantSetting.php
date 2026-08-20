<?php

namespace App\Filament\Resources\RestaurantSettings\Pages;

use App\Filament\Resources\RestaurantSettings\RestaurantSettingResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewRestaurantSetting extends ViewRecord
{
    protected static string $resource = RestaurantSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
