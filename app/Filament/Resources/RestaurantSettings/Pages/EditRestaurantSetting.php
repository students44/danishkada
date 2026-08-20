<?php

namespace App\Filament\Resources\RestaurantSettings\Pages;

use App\Filament\Resources\RestaurantSettings\RestaurantSettingResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditRestaurantSetting extends EditRecord
{
    protected static string $resource = RestaurantSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
