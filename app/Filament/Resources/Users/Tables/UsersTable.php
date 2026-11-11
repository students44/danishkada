<?php

namespace App\Filament\Resources\Users\Tables;

use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Customer Name')
                    ->weight('bold')
                    ->searchable()
                    ->sortable()
                    ->icon(Heroicon::OutlinedUser),

                TextColumn::make('email')
                    ->label('Email Address')
                    ->copyable()
                    ->searchable()
                    ->sortable()
                    ->icon(Heroicon::OutlinedEnvelope),

                TextColumn::make('orders_count')
                    ->counts('orders')
                    ->label('Orders Placed')
                    ->badge()
                    ->color('primary')
                    ->sortable(),

                TextColumn::make('email_verified_at')
                    ->label('Email Verified')
                    ->dateTime('d M Y')
                    ->placeholder('Unverified')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Joined')
                    ->since()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
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
