<?php

namespace App\Filament\Resources;

use App\Enums\ArmadaStatus;
use App\Filament\Resources\ArmadaResource\Pages;
use App\Filament\Resources\ArmadaResource\RelationManagers;
use App\Models\Armada;
use Filament\Forms;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ArmadaResource extends Resource
{
    protected static ?string $model = Armada::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return ('Manage Armada');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('code')
                    ->required()
                    ->maxLength(255),
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('manufacturer')
                    ->required()
                    ->maxLength(255),
                TextInput::make('production_year')
                    ->required()
                    ->maxLength(255),
                TextInput::make('capacity')
                    ->required()
                    ->maxLength(255),
                Select::make('status')->options([
                    'ACTIVE' => 'ACTIVE',
                    'RESERVED' => 'RESERVED',
                    'MAINTENANCE' => 'MAINTENANCE',
                    'OFF' => 'OFF',
                ]),
                Section::make('Armada Class')->schema([
                    CheckboxList::make('classes')->relationship('classes', 'name')->label(''),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('code')->searchable(),
                TextColumn::make('production_year')->searchable()->sortable(),
                TextColumn::make('name')->searchable()
                    ->description(fn ($record) => $record->manufacturer),

                TextColumn::make('capacity')->searchable(),
                TextColumn::make('status'),
            ])
            ->filters([
                SelectFilter::make('status')->options([
                    'ACTIVE' => 'ACTIVE',
                    'RESERVED' => 'RESERVED',
                    'MAINTENANCE' => 'MAINTENANCE',
                    'OFF' => 'OFF',
                ]),
                SelectFilter::make('manufacturer')->options(
                    Armada::all()->pluck('manufacturer', 'manufacturer')
                ),
                SelectFilter::make('production_year')->options(
                    Armada::all()->pluck('production_year', 'production_year')
                )
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListArmadas::route('/'),
            'create' => Pages\CreateArmada::route('/create'),
            'edit' => Pages\EditArmada::route('/{record}/edit'),
        ];
    }
}
