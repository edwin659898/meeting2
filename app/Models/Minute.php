<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Minute extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'meeting_id',
        'meeting_type',
        'end_time',
        'previous_observation',
        'chairperson',
        'chairperson_comment',
        'minutes_taker',
        'week_no',
        'access_password',
        'user_publish_notify',
    ];

    public function attendies(){
        return $this->hasMany(Attendance::class);
    }

    public function discussions(){
        return $this->hasMany(Discussion::class);
    }

    public function invites(){
        return $this->hasMany(MinuteUser::class);
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($minute) { // before delete() method call this
             Attendance::where('minute_id',$minute->id)->delete();
             $minute->discussions()->delete();
             DB::table('minute_user')->where('minute_id',$minute->id)->delete();
        });
    }

    public function meeting(){
        return $this->belongsTo(Meeting::class);
    }

    public function writer(){
        return $this->belongsTo(User::class,'minutes_taker');
    }

    public function chairperson(){
        return $this->belongsTo(User::class,'chairperson');
    }
}
