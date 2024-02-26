<?php

namespace App\Filament\Pages;

use App\Models\Attendance;
use App\Models\Discussion;
use App\Models\Meeting;
use App\Models\Minute as ModelsMinute;
use App\Models\User;
use Carbon\Carbon;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class Minute extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.minute';

    protected static ?string $navigationGroup = 'Manage Minutes';

    protected static ?string $navigationLabel = '1st Time Minute';


    public $meeting_id, $zoom_link, $Meeting_code, $passcode, $meeting_type;

    public $members_present;

    public $department, $discussion, $AOB, $Discussions;

    public $minute_id, $ongoing_meeting, $users, $invited;

    public $team_members = [], $meetings = [], $invites = [];

    public $minute_progress = 0, $value;


    protected static function shouldRegisterNavigation(): bool
    {
        //return auth()->user()->hasRole('super admin');
        return auth()->user()->hasAnyRole(['Minutes taker', 'Secondary Minutes taker']);
    }

    public function mount(): void
    {
        $this->users = User::all();
        $this->meetings = auth()->user()->meetings->pluck('name', 'id')->toArray();
    }

    public function updatedMeetingId($value)
    {
        if ($value !== "") {
            $selected_meeting = Meeting::find($value);
            $this->team_members = $selected_meeting->user;
            $this->zoom_link = $selected_meeting->zoom_link;
            $this->Meeting_code = $selected_meeting->meeting_id;
            $this->meeting_id = $selected_meeting->id;
            $this->passcode = $selected_meeting->passcode;
        }
    }

    public function updatedInvited($user)
    {
        $data = collect(json_decode($user, true))->toArray();
        array_push($this->invites, [$data['id'], $data['name']]);
        $this->reset('invited');
    }


    public function unsetting($index)
    {
        unset($this->invites[$index]);
    }

    public function saveSectionOne()
    {
        $data = $this->validate([
            'meeting_id' => 'required',
            'meeting_type' => 'required',
            'members_present' => 'required',
        ]);

        $this->ongoing_meeting = ModelsMinute::Create([
            'user_id' => auth()->id(),
            'meeting_id' => $data['meeting_id'],
            'meeting_type' => $data['meeting_type'],
            'minutes_taker' => auth()->id()
        ]);

        $this->minute_id = $this->ongoing_meeting->id;

        foreach ($data['members_present'] as $key => $value) {
            $attendance = Attendance::create([
                'minute_id' => $this->minute_id,
                'user_id' => $key,
            ]);

            if ($value == 'attended') {
                $attendance->update([
                    'attended' => 'yes'
                ]);
            } elseif ($value == 'not_attended_apologetic') {
                $attendance->update([
                    'attended' => 'no',
                    'gave_apology' => 'Yes',
                ]);
            } else {
                $attendance->update([
                    'attended' => 'no',
                    'gave_apology' => 'no',
                ]);
            }
        }

        if ($this->invites != '') {
            foreach ($this->invites as $key => $value) {
                DB::table('minute_user')->insert([
                    'minute_id' => $this->minute_id,
                    'user_id' => $value[0],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }

        Notification::make()
            ->title('saved')
            ->icon('heroicon-o-document-text')
            ->iconColor('success')
            ->send();

        return redirect('/admin/minutes');
    }

    public function saveSectionTwo()
    {
        $data = $this->validate([
            'value' => 'required',
        ]);

        $this->ongoing_meeting->update([
            'previous_observation' => $data['value']
        ]);

        Notification::make()
            ->title('saved')
            ->icon('heroicon-o-document-text')
            ->iconColor('success')
            ->send();

    }

    public function saveSectionThree()
    {

        $data = $this->validate([
            'discussion' => 'required',
            'department' => 'required',
            'AOB' => 'nullable',
        ]);

        Discussion::create([
            'minute_id' => $this->minute_id,
            'department' => $data['department'],
            'discussion' => $data['discussion'],
            'AOB' => $data['AOB'],
        ]);

        Notification::make()
            ->title('Discussion saved')
            ->icon('heroicon-o-document-text')
            ->iconColor('success')
            ->send();

        $this->reset('department', 'discussion', 'AOB');
    }

    public function destroyDiscussion($id)
    {
        Discussion::find($id)->delete();

        Notification::make()
            ->title('Deleted')
            ->icon('heroicon-o-document-text')
            ->iconColor('success')
            ->send();
    }

    public function complete()
    {
        if ($this->meeting_id != null) {
            $this->ongoing_meeting->update([
                'end_time' => Carbon::now()
            ]);

            Notification::make()
            ->title('Meeting ended')
            ->icon('heroicon-o-document-text')
            ->iconColor('success')
            ->send();

            return redirect('/admin');
        }
    }
}
