<?php
 
namespace App\Filament\Pages;

use App\Filament\Widgets\SptTerbaru;
use App\Filament\Widgets\StatsOverview;

class Dashboard extends \Filament\Pages\Dashboard
{
    public function getWidgets(): array
    {
        return [
            StatsOverview::class,
            SptTerbaru::class,
        ];
    }
}