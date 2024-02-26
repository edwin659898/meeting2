<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    use HasFactory;

    protected $fillable = ['minute_id','department','discussion','AOB'];

    public function minute(){
        return $this->belongsTo(Minute::class);
    }

    public static function boot() {
        parent::boot();

        static::creating(function(Discussion $discussion) {
             abort_if($discussion->minute->status == 'published' || $discussion->minute->user_id != auth()->id(),403);
        });
    }
}
