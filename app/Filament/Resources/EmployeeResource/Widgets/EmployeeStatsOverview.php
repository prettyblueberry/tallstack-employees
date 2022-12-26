<?php

namespace App\Filament\Resources\EmployeeResource\Widgets;

use App\Models\Employee;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class EmployeeStatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Employees', Employee::count()),
            Card::make('Bounce rate', '21%'),
            Card::make('Average time on page', '3:12'),
        ];
    }
}
