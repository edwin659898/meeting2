<?php

namespace App\Filament\Resources\ChairmanReviewResource\Pages;

use App\Filament\Resources\ChairmanReviewResource;
use Filament\Pages\Actions;
use Filament\Pages\Actions\EditAction;
use Filament\Resources\Pages\EditRecord;

class EditChairmanReview extends EditRecord
{
    protected static string $resource = ChairmanReviewResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['chairperson'] = auth()->id();

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
