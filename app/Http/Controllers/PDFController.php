<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Meeting;
use App\Models\Minute;
use App\Models\MinuteUser;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PDFController extends Controller
{
  // Generate PDF
  public function createPDF(Minute $record)
  {
    
    $data = $record->load('meeting', 'attendies.user', 'discussions', 'invites.user', 'writer', 'chairperson')
      ->toArray();
    $attendees_with_apology = Attendance::where(['minute_id' => $record->id, 'gave_apology' => 'Yes'])->count();
    $attendees_without_apology = Attendance::where(['minute_id' => $record->id, 'gave_apology' => 'no'])->count();
    $invited = MinuteUser::where(['minute_id' => $record->id])->count();
    return view('test', compact('data', 'attendees_with_apology', 'attendees_without_apology', 'invited'));
  }

  // view minute i am part of as PDF
  public function MyPublishedMeeting($password)
  {

    $record = Minute::where('access_password', $password)->first();
    if ($record) {
      $data = $record->load('meeting', 'attendies.user', 'discussions', 'invites.user', 'writer', 'chairperson')
        ->toArray();
      $attendees_with_apology = Attendance::where(['minute_id' => $record->id, 'gave_apology' => 'Yes'])->count();
      $attendees_without_apology = Attendance::where(['minute_id' => $record->id, 'gave_apology' => 'no'])->count();
      $invited = MinuteUser::where(['minute_id' => $record->id])->count();
      return view('test', compact('data', 'attendees_with_apology', 'attendees_without_apology', 'invited'));
    } else {
      abort(404);
    }
  }

  //send email to chairman
  public function notifyChairman(Minute $record)
  {
    $meeting = Meeting::find($record->meeting_id);

    $record->update(['status' => 'completed']);

    $chairman = $meeting->user()->where('member_role', 'Chairing')->first();

    $data = [
      'intro'  => 'Dear ' . $chairman->name . ',',
      'content'   => 'New ' . $meeting->name . ' has been well submitted for you review.',
      'name' => $chairman->name,
      'email' => $chairman->email,
      'subject'  => 'Required review and signature for ' . $meeting->name
    ];
    Mail::send('emails.notify-chairman', $data, function ($message) use ($data) {
      $message->to($data['email'], $data['name'])
        ->subject($data['subject']);
    });

    Notification::make()
      ->title('Minute Completed')
      ->success()
      ->send();

    return redirect('/admin/minutes');
  }
}
