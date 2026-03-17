<?php

namespace App\Filament\Resources\Crises\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;

class CrisisForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('Crisis_Type')
                    ->maxLength(255),

                Textarea::make('Crisis_Description')
                    ->columnSpanFull(),

                Select::make('Crisis_Severity')
                    ->options([
                        'Low' => 'Low',
                        'Medium' => 'Medium',
                        'High' => 'High',
                        'Critical' => 'Critical',
                    ]),

                Select::make('Impact_level')
                    ->options([
                        'Minor' => 'Minor',
                        'Moderate' => 'Moderate',
                        'Severe' => 'Severe',
                    ]),

                TextInput::make('Location'),

                DateTimePicker::make('Date_Reported')
                    ->seconds(false),

                Select::make('Status')
                    ->options([
                        'Open' => 'Open',
                        'Investigating' => 'Investigating',
                        'Resolved' => 'Resolved',
                        'Closed' => 'Closed',
                    ]),
            ]);
    }
}
