<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use Filament\Actions;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewTransaction extends ViewRecord
{
    protected static string $resource = TransactionResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Section::make('User')->schema([
                TextEntry::make('user.name')->label('Name'),
                TextEntry::make('user.email')->label('Email'),
                TextEntry::make('user.phone')->label('Phone'),
            ])->columns(3),
            Section::make('Transaction')->schema([
                TextEntry::make('status')->label('Transaction Status'),
                TextEntry::make('transaction_code')->label('Transaction Code'),
                TextEntry::make('total_price')->label('Total Price')->money('IDR'),
                TextEntry::make('updated_at')->label('Transaction Date'),
                TextEntry::make('originCity.name')->label('Origin City'),
                TextEntry::make('destinationCity.name')->label('Destination City'),
                TextEntry::make('armada_code')->label('Armada Code'),
                TextEntry::make('armada_name')->label('Armada Name'),
                TextEntry::make('classArmada.name')->label('Armada Class'),
                TextEntry::make('armada_seat')->label('Armada Seat'),

            ])->columns(4)
        ]);
    }
}
