<?php

namespace App\Filament\Resources\Reviews\Tables;

use App\Models\Review;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ReviewsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Diner')
                    ->weight('bold')
                    ->searchable()
                    ->icon(Heroicon::OutlinedUser),

                TextColumn::make('product.name')
                    ->label('Dish')
                    ->weight('medium')
                    ->searchable()
                    ->icon(Heroicon::OutlinedSparkles),

                TextColumn::make('rating')
                    ->label('Rating')
                    ->badge()
                    ->formatStateUsing(fn ($state) => str_repeat('★', $state) . " ({$state})")
                    ->color(fn ($state) => match ((int) $state) {
                        5 => 'success',
                        4 => 'primary',
                        3 => 'warning',
                        default => 'danger',
                    })
                    ->sortable(),

                TextColumn::make('comment')
                    ->label('Feedback')
                    ->limit(50)
                    ->tooltip(fn (Review $record) => $record->comment),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'approved' => 'success',
                        'pending' => 'warning',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('created_at')
                    ->label('Date')
                    ->since()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'approved' => 'Approved',
                        'pending' => 'Pending Approval',
                        'rejected' => 'Rejected',
                    ]),

                SelectFilter::make('rating')
                    ->options([
                        '5' => '5 Stars (Excellent)',
                        '4' => '4 Stars (Good)',
                        '3' => '3 Stars (Average)',
                        '2' => '2 Stars (Poor)',
                        '1' => '1 Star (Terrible)',
                    ]),
            ])
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
