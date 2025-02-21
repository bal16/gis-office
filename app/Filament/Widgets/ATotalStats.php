<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models;

class ATotalStats extends BaseWidget
{
    protected function getStats(): array
    {
        $districtCount = Models\District::count();
        $officeCount = Models\Office::count();
        return [
            Stat::make('Districts Count', "$districtCount Districts"),
            Stat::make('Office Count', "$officeCount Offices"),
        ];
    }

}
