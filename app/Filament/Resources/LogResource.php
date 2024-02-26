<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LogResource\Pages;
use App\Filament\Resources\LogResource\RelationManagers;
use App\Models\Log;
use App\Models\Minute;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Webbingbrasil\FilamentAdvancedFilter\Filters\DateFilter;
use Webbingbrasil\FilamentAdvancedFilter\Filters\NumberFilter;

class LogResource extends Resource
{
    protected static ?string $model = Minute::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';

    protected static ?string $navigationGroup = 'Review';

    protected static ?string $slug = 'minute-logs';

    protected static ?string $navigationLabel = 'Logs';

    protected $queryString = [
        'tableFilters',
        'tableSortColumn',
        'tableSortDirection',
        'tableSearchQuery' => ['except' => ''],
        'tableColumnSearchQueries',
    ];

    protected static function shouldRegisterNavigation(): bool
    {
        //return auth()->user()->hasRole('super_admin');
        return auth()->user()->hasRole('DDC');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Select::make('meeting_id')
                            ->relationship('meeting', 'name')
                            ->required()->label('Name of Meeting'),
                        Select::make('meeting_type')
                            ->required()
                            ->options([
                                'in person' => 'In person',
                                'virtual' => 'Virtual',
                            ]),
                    ])->columns(2),
                Card::make()
                    ->schema([
                        DateTimePicker::make('created_at')->label('Start Time')
                            ->required(),
                    ]),
                Card::make()
                    ->schema([
                        RichEditor::make('previous_observation')
                            ->required(),
                    ]),

                Card::make()
                    ->schema([
                        Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'rejected' => 'Return for amendments',
                                'published' => 'Published',
                            ])->disabled(),
                        RichEditor::make('chairperson_comment')->hidden(fn (Closure $get) => $get('status') == 'draft')->disabled()
                    ]),
                Card::make()
                    ->schema([
                        DateTimePicker::make('end_time')->label('End Time')
                            ->required()->disabled(!auth()->user()->hasRole('DDC')),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable()->Searchable(),
                Tables\Columns\TextColumn::make('meeting.name')->sortable()->Searchable(),
                Tables\Columns\TextColumn::make('created_at')->label('Happened on')->sortable()->Searchable(),
                Tables\Columns\TextColumn::make('week_no')->sortable()->Searchable(),
                Tables\Columns\TextColumn::make('meeting_type')->sortable()->Searchable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'draft',
                        'success' => 'published',
                    ]),
                Tables\Columns\TextColumn::make('writer.name')->label('Written By')->Searchable(),
            ])
            ->filters([
                DateFilter::make('created_at'),
                NumberFilter::make('week_no'),
            SelectFilter::make('status')
                ->options([
                    'draft' => 'Draft',
                    'reviewing' => 'Reviewing',
                    'published' => 'Published',
                ])
            ])
            ->actions([
                Tables\Actions\Action::make('pdf')
                ->visible(fn (Minute $record): bool => $record->status == 'published')
                ->url(fn (Minute $record): string => route('create.pdf', $record))
                ->icon('heroicon-s-download'),
            ])
            ->bulkActions([
                //Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            RelationManagers\AttendiesRelationManager::class,
            RelationManagers\InvitesRelationManager::class,
            RelationManagers\DiscussionsRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLogs::route('/'),
            'create' => Pages\CreateLog::route('/create'),
            'edit' => Pages\EditLog::route('/{record}/edit'),
        ];
    } 
    
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->orderBy('created_at','Desc');
    }
}
