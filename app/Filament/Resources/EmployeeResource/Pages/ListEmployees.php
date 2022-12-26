<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\EmployeeResource;
use App\Filament\Resources\EmployeeResource\Widgets\EmployeeStatsOverview;

class ListEmployees extends ListRecords
{
    protected static string $resource = EmployeeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getHeaderWidgets(): array
    {
        return [
            EmployeeStatsOverview::class
        ];
    }
}
