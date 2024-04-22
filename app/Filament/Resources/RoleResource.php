<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages;
use App\Models\Permission;
use App\Models\Role;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationIcon = 'heroicon-o-cog';

    public static function getNavigationGroup(): ?string
    {
        return ('Administrator');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name'),
                Section::make('Permissions')->schema(array_merge(
                    [
                        Fieldset::make('all_fieldset')
                            ->statePath(null)
                            ->label(__('Special Access'))
                            ->extraAttributes(['class' => 'text-primary-600'])
                            ->columns(1)
                            ->schema([
                                Checkbox::make('permissions.god_mode')
                                    ->label(__('SUPER ADMIN - ALL ACCESS'))
                                    ->helperText(__('Special permission to override all permissions.'))
                                    ->formatStateUsing(fn ($state) => boolval($state))
                                    ->reactive()
                            ]),
                    ],
                    static::getGroupPermissions()->map(
                        fn ($permissions, $group) =>
                        Fieldset::make($group)
                            ->label(ucwords($group))
                            ->schema($permissions->map(
                                fn ($permission) => //
                                Checkbox::make('permissions.' . base64_encode($permission->name))
                                    ->label($permission->name)
                                    ->extraAttributes(['class' => 'text-primary-600'])
                                    ->formatStateUsing(fn ($state) => boolval($state))
                                    ->reactive()
                                    ->afterStateUpdated(function ($component, $get, $set) {
                                        $name = base64_decode(str_replace(
                                            'data.permissions.',
                                            '',
                                            $component->getStatePath(),
                                        ));
                                        if ($component->getState() && str_contains($name, '*')) {
                                            static::getGroupPermissions()
                                                ->get(substr($name, 0, -2))
                                                ->each(fn ($p) => $set('permissions.' . base64_encode($p->name), true));
                                        }
                                    }),
                            )->toArray()),

                    )->toArray()
                ))->afterStateHydrated(function ($context, $record, $set) {
                    if ($context == 'view' || $context == 'edit') {
                        foreach ($record->permissions as $p) {
                            $set($p->name == '*'
                                ? 'permissions.god_mode'
                                : 'permissions.' . base64_encode($p->name), true);
                        }
                    }
                })->description('Assigned Permission To Role')
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('permissions_count')->counts('permissions')->badge()
            ])
            ->filters([
                //
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

    private static function getGroupPermissions(): Collection
    {
        return Permission::all()
            ->groupBy(function ($item) {
                $matches = [];
                preg_match_all('/.+?(?=\.)/', $item->name, $matches);

                return implode('', (array) @$matches[0]);
            })
            ->reject(fn ($permissions, $group) => blank($group));
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }

    public static function mutateDateForPermissions(array $data): array
    {
        $permissions = [];

        foreach (array_keys($data['permissions']) as $key) {
            if ($data['permissions'][$key]) {
                $permissions[] = $key == 'god_mode'
                    ? '*' : base64_decode((string) $key);
            }
        }

        $data['permissions'] = $permissions;

        return $data;
    }
}
