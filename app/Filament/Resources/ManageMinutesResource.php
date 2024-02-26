<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ManageMinutesResource\Pages;
use App\Filament\Resources\ManageMinutesResource\RelationManagers;
use App\Models\Attendance;
use App\Models\ManageMinutes;
use App\Models\Meeting;
use App\Models\Minute;
use Carbon\Carbon;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Actions\DeleteAction;
use Filament\Pages\Actions\ReplicateAction;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction as ActionsDeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ReplicateAction as ActionsReplicateAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ManageMinutesResource extends Resource
{
    protected static ?string $model = Minute::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationGroup = 'Manage Minutes';

    protected static ?string $navigationLabel = 'My Minutes';


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
                Tables\Columns\TextColumn::make('meeting_type')->sortable()->Searchable(),
                Tables\Columns\TextColumn::make('week_no')->sortable()->Searchable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'draft',
                        'success' => 'published',
                        'danger' => 'rejected',
                    ]),
                Tables\Columns\TextColumn::make('writer.name')->label('Written By')->Searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make()->color('success')->visible(fn (Minute $record): bool => $record->status == 'published'),
                Action::make('End Meeting')->icon('heroicon-o-document-text')
                    ->requiresConfirmation()
                    ->action(function (Minute $record): void {

                        $record->update(['end_time' => Carbon::now()->toDateTimeString()]);

                        Notification::make()
                            ->title('Meeting Ended')
                            ->success()
                            ->send();
                    })
                    ->visible(fn (Minute $record): bool => $record->end_time == NULL && $record->user_id == auth()->id()),
                Action::make('Replicate')->icon('heroicon-o-document-text')
                    ->requiresConfirmation()
                    ->action(function (Minute $record): void {

                        $newrecord = Minute::create([
                            'user_id' => auth()->id(),
                            'meeting_id' => $record->meeting_id,
                            'meeting_type' => $record->meeting_type,
                            'previous_observation' => $record->previous_observation,
                            'minutes_taker' => auth()->id(),
                            'week_no' => Carbon::now()->weekOfYear
                        ]);

                        foreach ($record->attendies as $attendance) {
                            if ($attendance->user->status) {
                                $attendance->create([
                                    'minute_id' => $newrecord->id,
                                    'user_id' => $attendance->user_id,
                                    'attended' => $attendance->attended,
                                    'gave_apology' => $attendance->gave_apology,
                                ]);
                            }
                        }

                        foreach ($record->discussions as $discussion) {

                            $discussion->create([
                                'minute_id' => $newrecord->id,
                                'department' => $discussion->department,
                                'discussion' => $discussion->discussion,
                                'AOB' => $discussion->AOB,
                            ]);
                        }
                        foreach ($record->invites as $invite) {
                            $invite->create([
                                'minute_id' => $newrecord->id,
                                'user_id' => $invite->user_id,
                            ]);
                        }

                        Notification::make()
                            ->title('Minute Replicated')
                            ->success()
                            ->send();
                    })
                    ->visible(fn (Minute $record): bool => $record->status == 'published' && $record->user_id == auth()->id()),
                EditAction::make()->visible(fn (Minute $record): bool => $record->user_id == auth()->id() && $record->status != 'published'),
                ActionsDeleteAction::make()->visible(fn (Minute $record): bool => $record->status == 'draft' && $record->user_id == auth()->id()),
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
            'index' => Pages\ListManageMinutes::route('/'),
            'create' => Pages\CreateManageMinutes::route('/create'),
            'edit' => Pages\EditManageMinutes::route('/{record}/edit'),
            'view' => Pages\ViewManageMinutes::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->WhereHas('attendies', function ($query) {
                $query->where('user_id', auth()->id());
            })->orderBy('created_at', 'Desc');
    }
}
