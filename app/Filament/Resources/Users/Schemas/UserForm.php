<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->unique(ignoreRecord: true)
                    ->required(),
                // DateTimePicker::make('email_verified_at'),
                Group::make()
                    ->schema([
                        TextEntry::make('generate_password')
                            ->label("Password"),
                        Action::make('resetPassword')
                            ->label(fn($operation) => $operation == 'edit' ? "Set New Password" : "Generate Password")
                            ->action(function ($set) {
                                $set('password', Str::password(16));
                            }),
                        TextInput::make('password')
                            ->hiddenLabel(true)
                            ->password()
                            ->revealable()
                            ->required()
                            ->minLength(12)
                            ->visible(fn($operation, $get) => $operation != 'edit' || ($operation == 'edit' && !empty($get('password')))),

                    ]),
                Checkbox::make('send_user_notification')
                ->inline()
                ->label(" Send the new user an email about their account")
                ->visible(fn($operation) => $operation == 'create'),
                 Group::make()
                    ->schema([
                        TextEntry::make('send_reset_link')
                            ->label("Password Reset"),
                        Action::make('resetLinkPassword')
                            ->label("Send Reset Link")
                             ->action(function ($set, $record) {
                                $data = $record->toArray();
                                $remember_token = base64_encode(Str::random(5) . "###" . $data['email']);
                                $content = "Name: {$data['name']}\n\n";
                                $content .= "To set your password, visit the following address:\n\n";
                                $content .= url('/change-password') . "?key={$remember_token}";

                                Mail::raw($content, function ($message) use ($data) {
                                    $message->to($data['email'])
                                        ->subject('Your Login Details');
                                });
                                $data['remember_token'] = $remember_token;
                            }),
                    ])
                     ->visible(fn($record, $operation) => $operation == 'edit' && auth()->user()->id != $record->id),
                // ->suffixAction(
                //     Action::make('generate')
                //         ->label('Generate password')
                //         ->action(function ($set) {
                //             $set('password', Str::password(16));
                //         })
                // )
                // ->extraAttributes([
                //     'x-data' => '',
                //     'x-on:input' => 'checkStrength($event.target.value)',
                // ])
                // ->helperText(
                //     fn() => new \Illuminate\Support\HtmlString(
                //         '<div x-text="strength" class="text-sm font-semibold text-green-600"></div>'
                //     )
                // ),
                CheckboxList::make('roles')
                    // ->required()
                    ->relationship(name: 'roles', titleAttribute: 'name')
                    ->saveRelationshipsUsing(function (Model $record, $state) {
                        $newRole = Role::whereIn('id', $state)->get();
                        $record->syncRoles([]);
                        $record->assignRole($newRole);
                    })
            ]);
    }
}
