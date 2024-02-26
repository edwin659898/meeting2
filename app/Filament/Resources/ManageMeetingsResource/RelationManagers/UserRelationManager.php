<?php

namespace App\Filament\Resources\ManageMeetingsResource\RelationManagers;

use App\Models\Meeting;
use App\Models\MeetingUser;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserRelationManager extends RelationManager
{
    protected static string $relationship = 'user';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->disabled(),
                Forms\Components\Select::make('member_role')
                    ->options([
                        'Chairing' => 'Chairman',
                        'S Chairing' => 'Secondary Chairman',
                        'Taking notes' => 'Minutes(Writer)',
                        'S Taking notes'  => 'Secondary Minutes(Writer)',
                        'Member' => 'Member',
                        'Observer' => 'Observer',
                    ])->disabled(!auth()->user()->hasRole('DDC')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('member_role'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->form(fn (Tables\Actions\AttachAction $action): array => [
                        $action->getRecordSelect(),
                        Forms\Components\Select::make('member_role')
                            ->options([
                                'Chairman' => 'Chairing',
                                'Secondary Chairman' => 'S Chairing',
                                'Minutes(Writer)' => 'Minutes',
                                'Secondary Minutes(Writer)' => 'S Minutes',
                                'Member' => 'Member',
                                'Observer' => 'Observer',
                            ]),
                    ])->visible(fn (RelationManager $livewire): bool => auth()->user()->isThisMeetingChairman($livewire->ownerRecord->id) == 'true'
                        || auth()->user()->hasRole('DDC')),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->visible(fn (RelationManager $livewire): bool => auth()->user()->isThisMeetingChairman($livewire->ownerRecord->id) == 'true'
                    || auth()->user()->hasRole('DDC')),
                Tables\Actions\DetachAction::make()->visible(fn (RelationManager $livewire): bool => auth()->user()->isThisMeetingChairman($livewire->ownerRecord->id) == 'true'
                    || auth()->user()->hasRole('DDC')),
            ])
            ->bulkActions([
                //
            ]);
    }
}
