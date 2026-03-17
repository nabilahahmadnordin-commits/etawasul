<?php

namespace App\Filament\Resources\Crises\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class CrisesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('Crisis_Type')->searchable(),

                TextColumn::make('Crisis_Severity')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Low' => 'gray',
                        'Medium' => 'warning',
                        'High' => 'danger',
                        'Critical' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('Impact_level')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Minor' => 'gray',
                        'Moderate' => 'warning',
                        'Severe' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Open' => 'danger',
                        'Investigating' => 'warning',
                        'Resolved' => 'success',
                        'Closed' => 'gray',
                        default => 'gray',
                    }),

                TextColumn::make('Location')->searchable(),
                TextColumn::make('Date_Reported')->dateTime()->sortable(),
                TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
                SelectFilter::make('Status')->options([
                    'Open' => 'Open',
                    'Investigating' => 'Investigating',
                    'Resolved' => 'Resolved',
                    'Closed' => 'Closed',
                ]),
                SelectFilter::make('Crisis_Severity')->options([
                    'Low' => 'Low',
                    'Medium' => 'Medium',
                    'High' => 'High',
                    'Critical' => 'Critical',
                ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->recordUrl(fn ($record) => route('filament.resources.crises.view', $record));
    }
}
