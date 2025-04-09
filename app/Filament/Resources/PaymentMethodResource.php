<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentMethodResource\Pages;
use App\Models\Cms\PaymentMethod;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PaymentMethodResource extends Resource
{
  protected static ?string $model = PaymentMethod::class;

  protected static ?string $navigationIcon = 'heroicon-o-banknotes';

  protected static ?int $navigationSort = 5;

  public static function getNavigationGroup(): ?string
  {
    return ('Administrator');
  }

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Select::make('parent')->label('Parents')->options(
          PaymentMethod::whereNull('parent')->get()->pluck('name', 'id')->toArray(),
        ),
        TextInput::make('name')->label('Name')->required(),
        TextInput::make('code')->label('Code')->required(),
        Select::make('country')->label('Country')->options([
          'ID' => 'Indonesia',
        ])->required(),
        Select::make('currency')->label('Currency')->options([
          'IDR' => 'Indonesia Rupiah',
        ])->required(),
        TextInput::make('sort')->label('Sort')->type('number'),
        Toggle::make('isActivated')->label('isActivated')->default(1),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        ImageColumn::make('icon')->label('Icon')->visible(fn($livewire) => $livewire->activeTab !== 'parent'),
        TextColumn::make('parents.name')
          ->label('Channels')
          ->searchable()
          ->visible(fn($livewire) => $livewire->activeTab !== 'parent'),
        TextColumn::make('name')->searchable(),
        TextColumn::make('code')->searchable(),
      ])
      ->filters([
        SelectFilter::make('parent')->label('Channels')->options(
          PaymentMethod::whereNull('parent')->get()->pluck('name', 'id')->toArray(),
        ),
        // ->visible(fn ($livewire) => $livewire->activeTab == 'Child')
        SelectFilter::make('isActivated')->label('isActivated')->options(
          [
            1 => 'Active',
            0 => 'Non Active'
          ]
        ),
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
      'index' => Pages\ListPaymentMethods::route('/'),
      'create' => Pages\CreatePaymentMethod::route('/create'),
      'edit' => Pages\EditPaymentMethod::route('/{record}/edit'),
    ];
  }
}
