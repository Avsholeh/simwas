<?php

namespace App\Filament\Widgets;

use App\Enums\SptStatus;
use App\Models\Pkpt;
use App\Models\Spt;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $spt = Spt::select('id', 'status')->whereRaw('YEAR(created_at) = ' . now()->year)->get();
        $sptTerbitCount = $spt->count();
        $sptDisetujuiCount = $spt->where('status', SptStatus::Disetujui->value)->count();

        $pkpt = Pkpt::select('id')->whereRaw('YEAR(created_at) = ' . now()->year)->get();
        $pkptCount = $pkpt->count();

        return [
            Stat::make('PKPT Diterbitkan', $pkptCount)->description(now()->format('F')),
            Stat::make('SPT Diterbitkan', $sptTerbitCount)->description(now()->format('F')),
            Stat::make('SPT Disetujui', $sptDisetujuiCount)->description(now()->format('F')),
        ];
    }
}
