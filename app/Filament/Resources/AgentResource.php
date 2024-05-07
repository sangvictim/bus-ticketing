<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AgentResource\Pages;
use App\Models\Agent;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Textarea;
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

class AgentResource extends Resource
{
    protected static ?string $model = Agent::class;

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return ('Manage Agents');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('city_id')->relationship('city', 'name')->searchable()->preload(),
                TextInput::make('name'),
                Textarea::make('address'),
                Split::make([
                    TextInput::make('contact_name'),
                    TextInput::make('mobile_phone'),
                ]),
                Toggle::make('isActive')->default(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                IconColumn::make('isActive')->label('Active')->boolean(),
                TextColumn::make('city.name')->label('City')->searchable(),
                TextColumn::make('name')->searchable(),
                TextColumn::make('contact_name')->description(fn (Agent $record) => $record->mobile_phone),
                TextColumn::make('address')->limit(50),
            ])
            ->filters([
                SelectFilter::make('isActive')->options([
                    1 => 'Active',
                    0 => 'Non Active'
                ]),
                SelectFilter::make('city')->relationship('city', 'name')->preload()->searchable()
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListAgents::route('/'),
            'create' => Pages\CreateAgent::route('/create'),
            'view' => Pages\ViewAgent::route('/{record}'),
            'edit' => Pages\EditAgent::route('/{record}/edit'),
        ];
    }
}
