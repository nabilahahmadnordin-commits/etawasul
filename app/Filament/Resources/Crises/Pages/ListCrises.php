<?php

namespace App\Filament\Resources\Crises\Pages;

use App\Filament\Resources\Crises\CrisisResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCrises extends ListRecords
{
    protected static string $resource = CrisisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
