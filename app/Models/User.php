<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'job_title',
        'site',
        'department',
        'department_two',
        'phone_number',
        'country',
        'password',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function meetings(){
        return $this->belongsToMany(Meeting::class)->withPivot('member_role');
    }

    public function invited(){
        return $this->belongsTo(Minute::class);
    }

    public function Attendedminutes(){
        return $this->HasMany(Attendance::class,'user_id');
    }

    public function isThisMeetingChairman($id){
        $meeting = Meeting::with('members')->whereHas('members', function ($q) {
            $q->whereMemberRole('Chairing')->where('user_id', auth()->id());
        })->find($id);
        return $meeting != Null;
    }

    
    public function canAccessFilament(): bool
    {
        return true;
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($user) { // before delete() method call this
             $user->update(['email' => time()."::".$user->email]);
        });
    }

}
