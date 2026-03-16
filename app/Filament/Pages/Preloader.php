<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Preloader extends Page
{
    protected string $view = 'filament.pages.preloader';
    protected static bool $shouldRegisterNavigation = false;
}
