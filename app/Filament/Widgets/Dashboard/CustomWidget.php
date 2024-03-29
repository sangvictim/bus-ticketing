<?php

namespace App\Filament\Widgets\Dashboard;

use App\Models\User;
use Filament\Widgets\Widget;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Collection;

class CustomWidget extends Widget
{
    protected static string $view = 'filament.widgets.dashboard.custom-widget';

    protected static ?int $sort = 3;

    public ?string $filter = 'today';

    public int $total = 3;

    protected static bool $isLazy = false;

    // protected int | string | array $columnSpan = 'full';


    public function getHeading(): string | Htmlable | null
    {
        return "Top {$this->total} Data";
    }

    protected function getData(): Collection
    {
        $data = User::whereBetween('created_at', $this->getFilterDates())->take($this->total)->get();
        return $data;
    }

    protected function getFilters(): ?array
    {
        return [
            'today' => 'Today',
            'this-week' => 'This Week',
            'this-month' => 'This Month',
            'last-month' => 'Last Month',
        ];
    }

    protected function getFilterDates(): array
    {
        return [
            'today' => [
                today()->startOfDay(),
                today()->endOfDay(),
            ],
            'this-week' => [
                today()->startOfWeek(),
                today()->endOfWeek(),
            ],
            'this-month' => [
                today()->startOfMonth(),
                today()->endOfMonth(),
            ],
            'last-month' => [
                today()->subMonth()->startOfMonth(),
                today()->subMonth()->endOfMonth(),
            ],
        ][$this->filter];
    }
}
