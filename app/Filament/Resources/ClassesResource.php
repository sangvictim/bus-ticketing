<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClassesResource\Pages;
use App\Filament\Resources\ClassesResource\RelationManagers;
use App\Filament\Resources\ClassesResource\RelationManagers\FacilitiesRelationManager;
use App\Filament\Resources\ClassesResource\RelationManagers\SeatsRelationManager;
use App\Models\Classes;
use App\Models\Facility;
use Filament\Forms;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClassesResource extends Resource
{
    protected static ?string $model = Classes::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): ?string
    {
        return ('Manage Armada');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name'),
                // Section::make('Facilities')->schema([
                //     CheckboxList::make('facilities')->label('')->required()->relationship('facilities', 'name'),

                // ]),
                // Section::make('Seats')->schema([
                //     CheckboxList::make('seats')->label('')->required()->relationship('seats', 'seat_number'),

                // ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('facilities.name'),
            ])
            ->filters([
                //
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
            FacilitiesRelationManager::class,
            SeatsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClasses::route('/'),
            'create' => Pages\CreateClasses::route('/create'),
            'view' => Pages\ViewClasses::route('/{record}'),
            'edit' => Pages\EditClasses::route('/{record}/edit'),
        ];
    }
}
