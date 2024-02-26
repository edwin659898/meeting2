<?php

namespace App\Filament\Resources\ManageMinutesResource\Pages;

use App\Filament\Resources\ManageMinutesResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListManageMinutes extends ListRecords
{
    protected static string $resource = ManageMinutesResource::class;

    protected function getActions(): array
    {
        return [
            //Actions\CreateAction::make(),
        ];
    }
}
