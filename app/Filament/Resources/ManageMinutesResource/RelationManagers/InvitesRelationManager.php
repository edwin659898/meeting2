<?php

namespace App\Filament\Resources\ManageMinutesResource\RelationManagers;

use App\Models\Minute;
use App\Models\MinuteUser;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Request;

class InvitesRelationManager extends RelationManager
{
    protected static string $relationship = 'invites';

    protected static ?string $recordTitleAttribute = 'user_id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                      ->visible(fn (RelationManager $livewire): bool => $livewire->ownerRecord->user_id == auth()->id() && $livewire->ownerRecord->status != 'published'),
             ])
            ->actions([
                Tables\Actions\DeleteAction::make()
                    ->visible(fn (MinuteUser $record): bool => $record->minute->user_id == auth()->id() && $record->minute->status != 'published'),
            ])
            ->bulkActions([

            ]);
    }    
}
