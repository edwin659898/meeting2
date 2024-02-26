<?php

namespace App\Filament\Resources\ManageMinutesResource\RelationManagers;

use App\Filament\Pages\Minute;
use App\Models\Attendance;
use App\Models\Minute as ModelsMinute;
use App\Models\User;
use Closure;
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

class AttendiesRelationManager extends RelationManager
{
    protected static string $relationship = 'attendies';

    protected static ?string $recordTitleAttribute = 'user_id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->options(User::where('status',true)->orderBy('name','asc')->pluck('name','id'))
                    ->required(),
                Select::make('attended')
                    ->options([
                        'yes' => 'Yes',
                        'no' => 'No',
                    ])->required()->reactive(),
                Select::make('gave_apology')
                    ->options([
                        'yes' => 'Yes',
                        'no' => 'No',
                    ])->hidden(fn (Closure $get) => $get('attended') != 'no')
                    ->required(fn (Closure $get) => $get('attended') == 'no'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Name'),
                Tables\Columns\TextColumn::make('attended'),
                Tables\Columns\TextColumn::make('gave_apology'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->visible(fn (RelationManager $livewire): bool => $livewire->ownerRecord->user_id == auth()->id() && $livewire->ownerRecord->status != 'published'),

            ])
            ->actions([
                Tables\Actions\EditAction::make()
                ->visible(fn (Attendance $record): bool => $record->minute->user_id == auth()->id() && $record->minute->status != 'published'),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn (Attendance $record): bool => $record->minute->user_id == auth()->id() && $record->minute->status != 'published'),
            ])
            ->bulkActions([
                //
            ]);
    }
}
