<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class MeetingUser extends Pivot
{
    use HasFactory;

    public function meeting()
    {
        return $this->belongsTo(Meeting::class, 'meeting_id');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($meetinguser) { // before creating() method call this
            abort_unless(
                $meetinguser->meeting->members->where
                (['member_role' => 'Chairing', 'user_id', auth()->id()])->isNotEmpty() ||
                    auth()->user()->hasRole('DDC'),
                403
            );
        });
    }
}
