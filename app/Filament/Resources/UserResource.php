<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\MultiSelect;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationGroup = 'Filament Shield';

    protected static ?int $navigationSort = 1;

    protected $queryString = [
        'tableFilters',
        'tableSortColumn',
        'tableSortDirection',
        'tableSearchQuery' => ['except' => ''],
        'tableColumnSearchQueries',
    ];

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Name')
                    ->disableAutocomplete()
                    ->required(),
                TextInput::make('job_title')
                    ->label('Job Title')->required(),
                TextInput::make('email')
                    ->label('Email')->unique(ignoreRecord: true),
                TextInput::make('phone_number')
                    ->label('phone no')->required()->unique(ignoreRecord: true),
                Select::make('country')
                    ->label('Country')
                    ->options([
                        'KE' => 'Kenya',
                        'UG' => 'Uganda',
                        'TZ' => 'Tanzania',
                    ])
                    ->required(),
                Select::make('site')
                    ->label('Site')
                    ->options([
                        'Dokolo' => 'Dokolo',
                        'Head Office' => 'Head Office',
                        'Kampala' => 'Kampala',
                        'Kiambere' => 'Kiambere',
                        'Nyongoro' => 'Nyongoro',
                        '7 Forks' => '7 Forks',
                    ])
                    ->required(),
                Select::make('department')
                    ->label('Department')
                    ->options([
                        'Board' => 'Board',
                        'Communication' => 'Communication',
                        'External' => 'External',
                        'FSC' => 'FSC',
                        'Finance and Accounts' => 'Finance and Accounts',
                        'Forestry' => 'Forestry',
                        'GIC' => 'GIC',
                        'Human Resources' => 'Human Resources',
                        'IT' => 'IT',
                        'Miti Magazine' => 'Miti Magazine',
                        'Monitoring & Evaluation' => 'Monitoring & Evaluation',
                        'Operations' => 'Operations',
                        'Quality Management' => 'Quality Management',                        
                        'Sales & Marketing' => 'Sales & Marketing',
                        'Senior Management' => 'Senior Management',
                        'BGF Foundation' => 'BGF Foundation',
                    ])
                    ->required(),
                Select::make('department_two')
                    ->label('Department Other')
                    ->options([
                        'Communication' => 'Communication',
                        'External' => 'External',
                        'FSC' => 'FSC',
                        'Finance and Accounts' => 'Finance and Accounts',
                        'Forestry' => 'Forestry',
                        'GIC' => 'GIC',
                        'Human Resources' => 'Human Resources',
                        'IT' => 'IT',
                        'Miti Magazine' => 'Miti Magazine',
                        'Monitoring & Evaluation' => 'Monitoring & Evaluation',
                        'Operations' => 'Operations',
                        'Quality Management' => 'Quality Management',                        
                        'Sales & Marketing' => 'Sales & Marketing',
                        'Senior Management' => 'Senior Management',
                        'BGF Foundation' => 'BGF Foundation',
                    ]),
                Select::make('role.name')
                    ->relationship('roles', 'name')->label('Has Roles')
                    ->multiple()->preload(),
                TextInput::make('password')
                    ->password()
                    ->required()
                    ->visibleOn('create'),
                Select::make('status')
                    ->options([
                        '1' => 'Active',
                        '0' => 'Inactive',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable()->Searchable(),
                Tables\Columns\TextColumn::make('name')->sortable()->Searchable(),
                Tables\Columns\TextColumn::make('job_title')->sortable()->Searchable(),
                Tables\Columns\TextColumn::make('site')->sortable()->Searchable(),
                Tables\Columns\TextColumn::make('department')->sortable()->Searchable(),
                Tables\Columns\TextColumn::make('created_at')->Searchable(),
                Tables\Columns\TextColumn::make('status')->sortable()->Searchable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->color('success'),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->label('Delete')
                    ->visible(fn (User $record) => auth()->id() != $record->id),
                Tables\Actions\RestoreAction::make()->label('activate'),
            ])
            ->bulkActions([
                //Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ])
            ->orderBy('created_at','Desc');
    }
}
