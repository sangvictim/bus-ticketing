<?php

namespace App\Filament\Resources\PaymentMethodResource\Pages;

use App\Filament\Resources\PaymentMethodResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListPaymentMethods extends ListRecords
{
    protected static string $resource = PaymentMethodResource::class;

    public ?string $activeTab = 'parent';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'parent' => Tab::make('Parent')->modifyQueryUsing(fn (Builder $query) => $query->whereNull('parent')),
            'child' => Tab::make('Child')->modifyQueryUsing(fn (Builder $query) => $query->whereNotNull('parent'))
        ];
    }
}
