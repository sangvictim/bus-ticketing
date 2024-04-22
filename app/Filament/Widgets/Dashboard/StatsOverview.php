<?php

namespace App\Filament\Widgets\Dashboard;

use App\Models\Agent;
use App\Models\Armada;
use App\Models\Classes;
use App\Models\Route;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected static ?string $pollingInterval = null;

    protected function getStats(): array
    {
        return [
            Stat::make(
                label: 'Trayek',
                value: Route::query()->count(),
            ),
            Stat::make(
                label: 'Agen',
                value: Agent::query()->count(),
            ),
            Stat::make(
                label: 'Armada',
                value: Armada::query()->count(),
            ),
            Stat::make(
                label: 'Kelas Armada',
                value: Classes::query()->count(),
            ),
        ];
    }
}
