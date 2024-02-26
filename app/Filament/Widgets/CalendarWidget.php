<?php

namespace App\Filament\Widgets;

use App\Models\Meeting;
use Filament\Widgets\Widget;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class CalendarWidget extends FullCalendarWidget
{

    public function fetchEvents(array $fetchInfo): array
    {
            $meetings = Meeting::WhereHas('members', function ($query) {
                $query->where(['user_id' => auth()->id()]);
            })->whereNotNull('start_time')->get();


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
