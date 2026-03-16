<?php

namespace App\Filament\Pages;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Pages\Page;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Component;

class ChangePassword extends Page implements HasSchemas
{
    protected string $view = 'filament.pages.change-password';
    protected static bool $shouldRegisterNavigation = false;
    protected static string $layout = 'filament-panels::components.layout.simple';


    use InteractsWithSchemas;

    public ?array $data = [];
    public $key;
    public $user;

    public function mount(): void
    {
        $this->key = request()->input('key');

        if (! $this->key) {
            abort(404);
        }

        $this->user = User::where('remember_token', $this->key)->first();

        if (!$this->user) {
            abort(404);
        }

        $this->form->fill([
            'password' => Str::password(16),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('text1')
                    ->label("Enter your new password below or generate one."),
                Group::make()
                    ->schema([
                        TextEntry::make('generate_password')
                            ->label("Password"),
                        Action::make('resetPassword')
                            ->label("Generate Password")
                            ->action(function ($set) {
                                $set('password', Str::password(16));
                            }),
                        TextInput::make('password')
                            ->hiddenLabel(true)
                            ->password()
                            ->revealable()
                            ->required()
                            ->minLength(12),

                    ]),
                Action::make('submitPassword')
                    ->label("Submit")
                    ->action(function () {
                        $data = $this->form->getState();
                        $this->user->update([
                            'password' => $data['password'],
                            'remember_token' => '',
                        ]);

                        return redirect(url('/admin'));

                    }),
            ])
            ->statePath('data');
    }

    public function create(): void
    {
        dd($this->form->getState());
    }
}
