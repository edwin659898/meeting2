<?php

namespace App\Filament\Resources\ManageMeetingsResource\Pages;

use App\Filament\Resources\ManageMeetingsResource;
use App\Models\Meeting;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMeeting extends ViewRecord
{
    protected static string $resource = ManageMeetingsResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make()->visible(fn (Meeting $record): bool => auth()->user()->isThisMeetingChairman($record->id) == 'true'                        
            || auth()->user()->hasRole('DDC')),
        ];
    }
}
