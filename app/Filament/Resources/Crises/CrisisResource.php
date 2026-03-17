<?php

namespace App\Filament\Resources\Crises;

use App\Filament\Resources\Crises\Pages\CreateCrisis;
use App\Filament\Resources\Crises\Pages\EditCrisis;
use App\Filament\Resources\Crises\Pages\ListCrises;
use App\Filament\Resources\Crises\Schemas\CrisisForm;
use App\Filament\Resources\Crises\Tables\CrisesTable;
use App\Models\Crisis;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CrisisResource extends Resource
{
    protected static ?string $model = Crisis::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'crisis';

    public static function form(Schema $schema): Schema
    {
        return CrisisForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CrisesTable::configure($table);
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
            'index' => ListCrises::route('/'),
            'create' => CreateCrisis::route('/create'),
            'edit' => EditCrisis::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
