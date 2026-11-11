<?php

namespace App\Filament\Resources\RestaurantSettings;

use App\Filament\Resources\RestaurantSettings\Pages\CreateRestaurantSetting;
use App\Filament\Resources\RestaurantSettings\Pages\EditRestaurantSetting;
use App\Filament\Resources\RestaurantSettings\Pages\ListRestaurantSettings;
use App\Filament\Resources\RestaurantSettings\Pages\ViewRestaurantSetting;
use App\Filament\Resources\RestaurantSettings\Schemas\RestaurantSettingForm;
use App\Filament\Resources\RestaurantSettings\Schemas\RestaurantSettingInfolist;
use App\Filament\Resources\RestaurantSettings\Tables\RestaurantSettingsTable;
use App\Models\RestaurantSetting;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class RestaurantSettingResource extends Resource
{
    protected static ?string $model = RestaurantSetting::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingStorefront;

    protected static string|UnitEnum|null $navigationGroup = 'Store Settings';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return RestaurantSettingForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return RestaurantSettingInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RestaurantSettingsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRestaurantSettings::route('/'),
            'create' => CreateRestaurantSetting::route('/create'),
            'view' => ViewRestaurantSetting::route('/{record}'),
            'edit' => EditRestaurantSetting::route('/{record}/edit'),
        ];
    }
}
