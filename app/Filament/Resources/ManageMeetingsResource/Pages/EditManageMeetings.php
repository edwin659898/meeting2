<?php

namespace App\Filament\Resources\ManageMeetingsResource\Pages;

use App\Filament\Resources\ManageMeetingsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditManageMeetings extends EditRecord
{
    protected static string $resource = ManageMeetingsResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
