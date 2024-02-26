<?php

namespace App\Console\Commands;

use App\Models\Meeting;
use Carbon\Carbon;
use Illuminate\Console\Command;
use AfricasTalking\SDK\AfricasTalking;

class SendMeetingReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'meeting-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Meeting Reminder';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $meetings = Meeting::whereDate('start_time', Carbon::today())->get();
        foreach ($meetings as $meeting) {
            $to = Carbon::createFromFormat('Y-m-d H:i:s', $meeting->start_time);
            $from = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now()->toDateTimeString());

            if ($to->diffInMinutes($from) == 10 && $to->greaterThan($from)) {
                foreach ($meeting->user as $user) {
                    if($user->status){
                        if ($user->country == 'KE') {
                            $username = env('USERNAME_KE');
                            $apiKey   = env('PASS_KE');
                            $from = env('SENDER_KE');
                        } else {
                            $username = env('USERNAME_UG');
                            $apiKey   = env('PASS_UG');
                            $from = env('SENDER_UG');
                        }
    
                        $AT  = new AfricasTalking($username, $apiKey);
                        $sms = $AT->sms();
                        $result = $sms->send([
                            'from' => $from,
                            'to'      => $user->phone_number,
                            'message' => 'Dear ' . $user->name . ', your ' . $meeting->name . ' meeting starts in 10 minutes',
                        ]);
                    }
                }
            };
        }
    }
}
