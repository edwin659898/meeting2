<?php

namespace App\Filament\Widgets;

use App\Models\Meeting;
use Filament\Widgets\Widget;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class AdminCalendarWidget extends FullCalendarWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?string $title = 'Custom Page Title';

    public static function canView(?array $user = null): bool
{
    // When event is null, MAKE SURE you allow View otherwise the entire widget/calendar won't be rendered
    if (auth()->user()->hasRole('super admin')) {
        return true;
    }
    
    // Returning 'false' will not show the event Modal.
    return false;
}
    
    public function fetchEvents(array $fetchInfo): array
    {
        $meetings = Meeting::whereNotNull('start_time')->get();

        $data = $meetings->map(function($meeting, $key) {
            return [
                'id' => $meeting->id,
                'title' => $meeting->name,
                'start' => $meeting->start_time,
                'end' => $meeting->end_time,
                'url' => $meeting->zoom_link,
                'shouldOpenInNewTab' => true,
            ];
        })->toArray();
     
        return $data;
    }
}
