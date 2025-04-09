<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RouteResource\Pages;
use App\Models\Cms\Route;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class RouteResource extends Resource
{
    protected static ?string $model = Route::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): ?string
    {
        return ('Manage Trayek');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required(),
                Select::make('origin_city')->relationship('originCity', 'name')
                    ->required()->searchable()->preload(),
                Select::make('destination_city')->relationship('destinationCity', 'name')
                    ->required()->searchable()->preload(),
                TextInput::make('estimated_duration')->numeric()->suffix('minutes')->minValue(0),
                Toggle::make('isActive')->default(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                IconColumn::make('isActive')->label('Active')->boolean(),
                TextColumn::make('name')->searchable(),
                TextColumn::make('originCity.name'),
                TextColumn::make('destinationCity.name'),
                TextColumn::make('estimated'),
            ])
            ->filters([
                SelectFilter::make('origin_city')->label('Origin')->relationship('originCity', 'name')->preload(),
                SelectFilter::make('destination_city')->label('Destination')->relationship('destinationCity', 'name')->preload(),
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                ])
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
            'index' => Pages\ListRoutes::route('/'),
            'create' => Pages\CreateRoute::route('/create'),
            'edit' => Pages\EditRoute::route('/{record}/edit'),
        ];
    }
}
