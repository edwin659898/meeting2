<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'frequency',
        'status',
        'zoom_link',
        'meeting_id',
        'passcode',
        'start_time',
        'end_time',
    ];

    protected $dates = ['start_time', 'end_time'];

    public static function boot() {
        parent::boot();

        static::deleting(function($meeting) { // before delete() method call this
             $meeting->members()?->delete();
             $meeting->minutes()?->delete();
        });
    }

    public function user(){
        return $this->belongsToMany(User::class)->withPivot('member_role');
    }

    public function member(){
        return $this->belongsToMany(MeetingUser::class);
    }

    public function members(){
        return $this->hasMany(MeetingUser::class);
    }

    public function minutes(){
        $this->hasMany(Minute::class);
    }

}
