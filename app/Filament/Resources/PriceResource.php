<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PriceResource\Pages;
use App\Models\Cms\Classes;
use App\Models\Cms\Price;
use App\Models\Cms\Route;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PriceResource extends Resource
{
    protected static ?string $model = Price::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return ('Manage Trayek');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('route_id')
                    ->options(Route::all()->pluck('name', 'id'))
                    ->searchable()->required()->preload(),
                Select::make('class_id')
                    ->options(Classes::all()->pluck('name', 'id'))
                    ->searchable()->required()->preload(),
                TextInput::make('name')->required(),
                TextInput::make('price')->numeric()->minValue(0)
                    ->prefix('Rp')->required(),
                Grid::make(3)->schema([
                    TextInput::make('cut_of_price')->numeric()->minValue(0)
                        ->prefix('Rp'),
                    TextInput::make('discount')->numeric()->minValue(0),
                    Select::make('discount_type')->options([
                        'percentage' => 'Percentage',
                        'amount' => 'Amount',
                    ])
                ]),
                DatePicker::make('start_date'),
                DatePicker::make('end_date'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('route.name'),
                TextColumn::make('classes.name')->label('Class Armada'),
                TextColumn::make('name')->searchable(),
                TextColumn::make('price')->money('IDR'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPrices::route('/'),
            'create' => Pages\CreatePrice::route('/create'),
            'edit' => Pages\EditPrice::route('/{record}/edit'),
        ];
    }
}
