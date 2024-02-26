<?php

namespace App\Console\Commands;

use AfricasTalking\SDK\AfricasTalking;
use App\Models\Meeting;
use App\Models\Minute;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class NotifyUserOfPublishedMinutes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify-published';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify members when meetings are published';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $minutes = Minute::where('user_publish_notify', 'No')->where('status','published')->get();

        foreach($minutes as $minute){
            foreach ($minute->attendies as $user) {
                if($user->user->email != Null){
                    $data = [
                        'intro'  => 'Dear ' . $user->user->name . ',',
                        'content'   => 'Week '.$minute->week_no. ' ' . $minute->meeting->name . ' minutes have published. Logon to the system to view and generate pdf',
                        'password' => $minute->access_password,
                        'name' => $user->user->name,
                        'email' => $user->user->email,
                        'subject'  => 'Published minutes for ' . $minute->meeting->name
                      ];
                      Mail::send('emails.notify-published', $data, function ($message) use ($data) {
                        $message->to($data['email'], $data['name'])
                          ->subject($data['subject']);
                      });
                }else{
                    if ($user->user->country == 'KE') {
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
                        'to'      => $user->user->phone_number,
                        'message' => 'Dear '.$user->user->name.' Week '.$minute->week_no. ' ' . $minute->meeting->name . ' minutes have published. Request a pdf from the site responsible',
                    ]);
                }
            }

            foreach ($minute->invites as $user) {
                if($user->user->email != Null){
                    $data = [
                        'intro'  => 'Dear ' . $user->user->name . ',',
                        'content'   => 'Week '.$minute->week_no. ' ' . $minute->meeting->name . ' minutes have published. Logon to the system to view and generate pdf',
                        'password' => $minute->access_password,
                        'name' => $user->user->name,
                        'email' => $user->user->email,
                        'subject'  => 'Published minutes for ' . $minute->meeting->name
                      ];
                      Mail::send('emails.notify-published', $data, function ($message) use ($data) {
                        $message->to($data['email'], $data['name'])
                          ->subject($data['subject']);
                      });
                }else{
                    if ($user->user->country == 'KE') {
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
                        'to'      => $user->user->phone_number,
                        'message' => 'Dear '.$user->user->name.' Week '.$minute->week_no. ' ' . $minute->meeting->name . ' minutes have published. Request a pdf from the site responsible',
                    ]);
                }
            }

            $minute->update(['user_publish_notify'=>'Yes']);
        }
    }
}
