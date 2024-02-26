<?php

namespace App\Filament\Resources\LogResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class DiscussionsRelationManager extends RelationManager
{
    protected static string $relationship = 'discussions';

    protected static ?string $recordTitleAttribute = 'minute_id';

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
                                'Senior Management' => 'Senior Management',
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
                //Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
                //Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                //Tables\Actions\DeleteBulkAction::make(),
            ]);
    }    
}
