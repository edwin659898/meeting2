<?php

namespace App\Filament\Resources\ManageMeetingsResource\Pages;

use App\Filament\Resources\ManageMeetingsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListManageMeetings extends ListRecords
{
    protected static string $resource = ManageMeetingsResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
