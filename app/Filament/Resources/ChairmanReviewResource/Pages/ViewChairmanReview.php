<?php

namespace App\Filament\Resources\ChairmanReviewResource\Pages;

use App\Filament\Resources\ChairmanReviewResource;
use App\Models\Minute;
use Filament\Notifications\Notification;
use Filament\Pages\Actions;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewChairmanReview extends ViewRecord
{
    protected static string $resource = ChairmanReviewResource::class;

    protected function getActions(): array
    {
        return [
            Actions\Action::make('approve')->icon('heroicon-s-check-circle')->color('success')
                ->action(fn () => $this->record->update([
                    'chairperson' => auth()->id(),
                    'status' => 'published'
                ]),
            ),
            Actions\Action::make('decline')
                 ->icon('heroicon-s-x-circle')->color('danger')
                ->requiresConfirmation()
                 ->action(fn () => $this->record->update([
                    'chairperson' => auth()->id(),
                    'status' => 'rejected'
                ])),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

}
