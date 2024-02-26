<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class MinuteUser extends Pivot
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function minute()
    {
        return $this->belongsTo(Minute::class, 'minute_id');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function (MinuteUser $minuteuser) {
            abort_if($minuteuser->minute->status == 'published' || $minuteuser->minute->user_id != auth()->id(), 403);
        });
    }
}
