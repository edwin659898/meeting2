<?php

namespace App\Filament\Resources\ManageMinutesResource\RelationManagers;

use App\Models\Discussion;
use App\Models\Minute;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Request;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class DiscussionsRelationManager extends RelationManager
{
    protected static string $relationship = 'discussions';

    protected static ?string $recordTitleAttribute = 'department';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Select::make('department')
                            ->required()
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
                    ]),
                Card::make()
                    ->schema([
                        TinyEditor::make('discussion')
                            ->showMenuBar()
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsVisibility('public')
                            ->required(),
                    ]),
                Card::make()
                    ->schema([
                        TinyEditor::make('AOB')
                            ->label('AOB')
                            ->showMenuBar()
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsVisibility('public')
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('department'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('Create Item')
                    ->visible(fn (RelationManager $livewire): bool => $livewire->ownerRecord->user_id == auth()->id() && $livewire->ownerRecord->status != 'published'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->visible(fn (Discussion $record): bool => $record->minute->user_id == auth()->id() && $record->minute->status != 'published'),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn (Discussion $record): bool => $record->minute->user_id == auth()->id() && $record->minute->status != 'published'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
