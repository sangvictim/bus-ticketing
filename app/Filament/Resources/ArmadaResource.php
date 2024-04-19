<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArmadaResource\Pages;
use App\Models\Armada;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\Section as ComponentsSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

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
                Grid::make(3)->schema([
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
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                IconColumn::make('status')
                    ->icon(fn (string $state): string => match ($state) {
                        'RESERVED' => 'heroicon-o-clock',
                        'MAINTENANCE' => 'heroicon-o-cog-8-tooth',
                        'ACTIVE' => 'heroicon-o-check-circle',
                        'OFF' => 'heroicon-o-no-symbol',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'MAINTENANCE' => 'info',
                        'OFF' => 'warning',
                        'ACTIVE' => 'success',
                        'RESERVED' => 'gray',
                    }),
                TextColumn::make('code')->searchable(),
                TextColumn::make('production_year')->searchable()->sortable(),
                TextColumn::make('name')->searchable()
                    ->description(fn ($record) => $record->manufacturer),

                TextColumn::make('capacity')->searchable(),
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

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                ComponentsSection::make('Armada')->schema([
                    TextEntry::make('code')->label('Kode'),
                    TextEntry::make('name')->label('Nama'),
                    TextEntry::make('classes.name')->label('Kelas'),
                    TextEntry::make('capacity')->label('Kapasitas')->suffix(' Seat'),
                    TextEntry::make('manufacturer')->label('Pabrikan'),
                    TextEntry::make('production_year')->label('Tahun Produksi'),
                    TextEntry::make('status')->label('Status'),
                ])->columns(4)
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
            'view' => Pages\ViewArmada::route('/{record}'),
            'edit' => Pages\EditArmada::route('/{record}/edit'),
        ];
    }
}
