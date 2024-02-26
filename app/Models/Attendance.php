<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'minute_id',
        'user_id',
        'attended',
        'gave_apology',
    ];

    public function minute(){
        return $this->belongsTo(Minute::class);
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public static function boot() {
        parent::boot();

        static::creating(function(Attendance $attendance) {
             abort_if($attendance->minute->status == 'published' || $attendance->minute->user_id != auth()->id(),403);
        });

        self::updating(function(Attendance $attendance) { 
            if($attendance->attended == 'yes'){
                $attendance->gave_apology = '';
            }
        });
    }
}
