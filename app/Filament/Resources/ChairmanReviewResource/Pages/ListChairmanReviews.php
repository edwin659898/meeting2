<?php

namespace App\Filament\Resources\ChairmanReviewResource\Pages;

use App\Filament\Resources\ChairmanReviewResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListChairmanReviews extends ListRecords
{
    protected static string $resource = ChairmanReviewResource::class;

    protected function getActions(): array
    {
        return [
            //Actions\CreateAction::make(),
        ];
    }
}
