<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ScheduleResource\Pages;
use App\Filament\Resources\ScheduleResource\RelationManagers;
use App\Models\Schedule;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ScheduleResource extends Resource
{
    protected static ?string $model = Schedule::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 3;

    public static function getNavigationGroup(): ?string
    {
        return ('Manage Trayek');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('route_id')->relationship('route', 'name')->searchable()->preload()->required(),
                Select::make('armada_id')->relationship('armada', 'code')->searchable()->preload()->required(),
                Select::make('classes_id')->relationship('classes', 'name')->searchable()->preload()->required(),
                Select::make('price_id')->relationship('price', 'price')->searchable()->preload()->required(),
                TimePicker::make('arrival_time')->required(),
                TimePicker::make('departure_time')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('route.name')->searchable(),
                TextColumn::make('armada.code')->description(fn ($record) => $record->armada->name),
                TextColumn::make('arrival_time'),
                TextColumn::make('departure_time'),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                ])
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Route')->schema([
                    TextEntry::make('route.name')->label('Nama Trayek'),
                    TextEntry::make('route.originCity.name')->label('Asal Trayek'),
                    TextEntry::make('route.destinationCity.name')->label('Tujuan Trayek'),
                ])->columns(3),

                Section::make('Armada')->schema([
                    TextEntry::make('armada.code')->label('Kode Armada'),
                    TextEntry::make('armada.name')->label('Nama Armada'),
                    TextEntry::make('armada.classes.name')->label('Kelas Armada'),
                ])->columns(3),

                Section::make('Schedule')->schema([
                    TextEntry::make('arrival_time')->label('Waktu Kedatangan'),
                    TextEntry::make('departure_time')->label('Waktu Keberangkatan'),
                    TextEntry::make('route.estimated')->label('Estimasi Trayek'),
                ])->columns(3),

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
            'index' => Pages\ListSchedules::route('/'),
            'create' => Pages\CreateSchedule::route('/create'),
            'view' => Pages\ViewSchedule::route('/{record}'),
            'edit' => Pages\EditSchedule::route('/{record}/edit'),
        ];
    }
}
