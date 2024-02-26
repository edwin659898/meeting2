<?php

namespace App\Filament\Resources\ChairmanReviewResource\RelationManagers;

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
                            'Senior Management' => 'Senior Management',
                        ]),
                ]),
            Card::make()
                ->schema([
                    TinyEditor::make('discussion')
                        ->showMenuBar()
                        ->fileAttachmentsDisk('admin-uploads')
                        ->fileAttachmentsVisibility('public'),
                ]),
            Card::make()
                ->schema([
                    TinyEditor::make('AOB')
                        ->label('AOB')
                        ->showMenuBar()
                        ->fileAttachmentsDisk('admin-uploads')
                        ->fileAttachmentsVisibility('public'),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('department'),
                //Tables\Columns\TextColumn::make('discussion')->html(),
                //Tables\Columns\TextColumn::make('AOB')->html(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make('view'),
                Tables\Actions\EditAction::make('edit'),
                //Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                //Tables\Actions\DeleteBulkAction::make(),
            ]);
    }    
}
