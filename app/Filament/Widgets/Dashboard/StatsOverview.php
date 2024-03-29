<?php

namespace App\Filament\Widgets\Dashboard;

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
                label: 'Total User',
                value: User::query()->count(),
            ),
            Stat::make(
                label: 'Rate',
                value: '3:12',
            ),
            Stat::make('Average time on page', '3:12')->chart([7, 2, 10, 3, 15, 4, 17])->color('success'),
        ];
    }
}
