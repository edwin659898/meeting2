<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChairmanReviewResource\Pages;
use App\Filament\Resources\ChairmanReviewResource\RelationManagers;
use App\Models\ChairmanReview;
use App\Models\Minute;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ChairmanReviewResource extends Resource
{
    protected static ?string $model = Minute::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';

    protected static ?string $navigationGroup = 'Review';

    protected static ?string $navigationLabel = 'Chairman Review';

    protected static ?string $slug = 'chairman-review';


    protected static function shouldRegisterNavigation(): bool
    {
        //return auth()->user()->hasRole('super_admin');
        return auth()->user()->hasRole('Chair');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Select::make('meeting_id')
                            ->relationship('meeting', 'name')
                            ->disabled()->label('Name of Meeting'),
                        Select::make('meeting_type')
                            ->disabled()
                            ->options([
                                'in person' => 'In person',
                                'virtual' => 'Virtual',
                            ]),
                    ])->columns(2),
                Card::make()
                    ->schema([
                        DateTimePicker::make('created_at')->label('Start Time')
                            ->disabled(),
                    ]),
                Card::make()
                    ->schema([
                        RichEditor::make('previous_observation')->required(),
                    ]),

                Card::make()
                    ->schema([
                        TextInput::make('end_time')->label('End Time')
                            ->disabled(),
                    ]),
                Card::make()
                    ->schema([
                        Select::make('status')
                            ->options([
                                'rejected' => 'Return for amendments',
                                'published' => 'Published',
                            ])->required(),
                        RichEditor::make('chairperson_comment')
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
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->icon('heroicon-o-eye')
                ->color('success')->label('view'),
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
            'index' => Pages\ListChairmanReviews::route('/'),
            'create' => Pages\CreateChairmanReview::route('/create'),
            'edit' => Pages\EditChairmanReview::route('/{record}/edit'),
            'view' => Pages\ViewChairmanReview::route('/{record}'),
        ];
    }  
    
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->WhereHas('meeting', function ($query) {
                $query->WhereHas('members', function ($query) {
                    $query->where(['user_id'=> auth()->id(),'member_role'=> 'Chairing']);
                });
            })
            ->where('status','=','completed')
            ->orderBy('created_at','Desc');
    }
}
