<?php

namespace App\Filament\Resources\ManageMinutesResource\Pages;

use App\Filament\Resources\ManageMinutesResource;
use App\Models\Minute;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;


class EditManageMinutes extends EditRecord
{
    protected static string $resource = ManageMinutesResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make()->visible(fn (Minute $record): bool => $record->status == 'draft' && $record->user_id == auth()->id()),
            Actions\Action::make('complete')->label('Complete')
                   ->visible(fn (): bool => $this->record->status == 'draft' && $this->record->user_id == auth()->id() || $this->record->status == 'rejected' && $this->record->user_id == auth()->id())
                   ->requiresConfirmation()->url(fn (): string => route('complete', $this->record)),
        ];
    }
}
