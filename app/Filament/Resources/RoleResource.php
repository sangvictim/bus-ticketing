<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages;
use App\Models\Cms\Permission;
use App\Models\Cms\Role;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Collection;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static Collection $permissionsCollection;

    public static function getNavigationGroup(): ?string
    {
        return ('Administrator');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make(__('Role'))->schema([
                TextInput::make('name')
                    ->label(__('Name'))
                    ->columnSpanFull()
                    ->required()
                    ->unique(ignoreRecord: true),
                TextInput::make('guard_name')
                    ->hidden()
                    ->default('admin'),
            ]),
            Section::make(__('Users'))->schema([
                Select::make('users')
                    ->label(__('Attach to'))
                    ->columnSpanFull()
                    ->relationship(
                        'users',
                        'name',
                        fn($query) => //
                        $query->take(config('base.records_limit.users')),
                    )
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->getOptionLabelFromRecordUsing(
                        fn($record) => //
                        "{$record->name} — {$record->email}",
                    ),
            ]),
            Section::make(__('Access'))->schema(
                array_merge(
                    [
                        Fieldset::make('all_fieldset')
                            ->statePath(null)
                            ->label(__('Special Access'))
                            ->extraAttributes(['class' => 'text-primary-600'])
                            ->columns(1)
                            ->schema([
                                Checkbox::make('permissions.god_mode')
                                    ->label(__('SUPERADMIN - ALL ACCESS'))
                                    ->helperText(__('Special permission to override all permissions.'))
                                    ->formatStateUsing(fn($state) => boolval($state))
                                    ->reactive(),
                            ]),
                    ],
                    static::getGroupPermissions()->map(
                        fn($permissions, $group) => //
                        Fieldset::make($group . '.fieldset')
                            ->statePath(null)
                            ->label(__('Access') . ' — ' . __(ucwords($group)))
                            ->extraAttributes(['class' => 'text-primary-600'])
                            ->columns(5)
                            ->visible(fn($get) => !boolval($get('permissions.god_mode')))
                            ->schema($permissions->map(
                                fn($permission) => //
                                Checkbox::make('permissions.' . base64_encode($permission->name))
                                    ->label(__($permission->name))
                                    ->extraAttributes(['class' => 'text-primary-600'])
                                    ->formatStateUsing(fn($state) => boolval($state))
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
                                                ->each(fn($p) => $set('permissions.' . base64_encode($p->name), true));
                                        }
                                    }),
                            )->toArray()),
                    )->toArray(),
                ),
            )->afterStateHydrated(function ($context, $record, $set) {
                if ($context == 'view' || $context == 'edit') {
                    foreach ($record->permissions as $p) {
                        $set($p->name == '*'
                            ? 'permissions.god_mode'
                            : 'permissions.' . base64_encode($p->name), true);
                    }
                }
            }),
        ]);
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
            ->reject(fn($permissions, $group) => blank($group));
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
