<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Club extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function clubType()
    {
        return $this->belongsTo('App\ClubType');
    }

    public function country()
    {
        return $this->belongsTo('App\Country');
    }

    public function users()
    {
        return $this->belongsToMany('\App\User', 'users_clubs')
            ->withPivot('role')
            ->withTimestamps();
    }

    public function events()
    {
        return $this->hasMany('\App\Event');
    }

    public function photos()
    {
        return $this->hasMany('\App\ClubPhoto');
    }

    public function owners()
    {
        return $this->belongsToMany('App\User', 'users_clubs')
            ->withPivot('role')
            ->withTimestamps()
            ->wherePivot('role', 'owner');
    }

    public function administrators()
    {
        return $this->belongsToMany('App\User', 'users_clubs')
            ->withPivot('role')
            ->withTimestamps()
            ->wherePivot('role', 'administrator');
    }

    public function members()
    {
        return $this->belongsToMany('App\User', 'users_clubs')
            ->withPivot('role')
            ->withTimestamps()
            ->wherePivot('role', 'member');
    }
}
