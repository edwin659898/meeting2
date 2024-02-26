<?php

namespace App\Filament\Resources\ManageMinutesResource\Pages;

use App\Filament\Resources\ManageMinutesResource;
use App\Models\Minute;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewManageMinutes extends ViewRecord
{
    protected static string $resource = ManageMinutesResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make()->visible(fn (Minute $record): bool => $record->status == 'draft' && $record->user_id == auth()->id()),
        ];
    }
}
