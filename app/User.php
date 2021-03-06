<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use NotificationChannels\WebPush\HasPushSubscriptions;

class User extends Authenticatable
{
    use Notifiable;
    use HasPushSubscriptions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'provider', 'provider_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function clubs()
    {
        return $this->belongsToMany('App\Club', 'users_clubs')
            ->withPivot('role')
            ->withTimestamps();
    }

    public function ownedClubs()
    {
        return $this->belongsToMany('App\Club', 'users_clubs')
            ->withPivot('role')
            ->withTimestamps()
            ->wherePivot('role', 'owner');
    }

    public function administratedClubs()
    {
        return $this->belongsToMany('App\Club', 'users_clubs')
            ->withPivot('role')
            ->withTimestamps()
            ->wherePivotIn('role', ['administrator', 'owner']);
    }

    public function memberedClubs()
    {
        return $this->belongsToMany('App\Club', 'users_clubs')
            ->withPivot('role')
            ->withTimestamps()
            ->wherePivotIn('role', ['member', 'administrator', 'owner']);
    }

    public function events()
    {
        return $this->belongsToMany('App\Event', 'users_events')
            ->withTimestamps();
    }

    public function pushSubscriptions()
    {
        return $this->hasMany('\App\PushSubscription');
    }
}
