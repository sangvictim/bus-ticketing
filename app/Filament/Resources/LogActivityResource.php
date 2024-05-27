<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LogActivityResource\Pages;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\Models\Activity;

class LogActivityResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    protected static ?int $navigationSort = 4;

    protected static ?string $label = "Log Activity";

    public static function getNavigationGroup(): ?string
    {
        return ('Administrator');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('log_name')->label('Log Name')->searchable(),
                TextColumn::make('description')->label('Description')->searchable()
                    ->description(fn (Activity $record) => $record->causer->name ?? 'Unknown' . ' ' . $record->event . ' ' . $record->log_name . ' ' . $record->subject->name),
                TextColumn::make('created_at')->label('Created At')
            ])
            ->filters([
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from')->default(now()),
                        DatePicker::make('created_until')->default(now()),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
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
            'index' => Pages\ListLogActivities::route('/'),
            // 'create' => Pages\CreateLogActivity::route('/create'),
            // 'edit' => Pages\EditLogActivity::route('/{record}/edit'),
        ];
    }
}
