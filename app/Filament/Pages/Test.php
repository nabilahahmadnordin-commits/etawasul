<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Pages\Page;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Test extends Page implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;
    protected string $view = 'filament.pages.test';

    public function logoutAction(): Action
    {
        return Action::make('logout')
            ->label('Logout')
            ->color('danger')
            ->icon('heroicon-o-arrow-left-on-rectangle')
            ->action(function () {
                
                Auth::logout();

                session()->invalidate();
                session()->regenerateToken();

              
                return redirect('/');
            });
    }
}
