<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models;

class BOfficeStats extends BaseWidget
{
    protected function getStats(): array
    {
        $districtOfficeCount = Models\Office::where('is_district', '=', true)->count();
        $villageOfficeCount = Models\Office::where('is_district', '=', false)->count();
        return [
            Stat::make('District Office Count', "$districtOfficeCount Offices"),
            Stat::make('Village Office Count', "$villageOfficeCount Offices"),
        ];
    }
}
