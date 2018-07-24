<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at', 'start_date', 'end_date', 'recurrence_end_date'];

    public function country()
    {
        return $this->belongsTo('App\Country');
    }

    public function club()
    {
    	return $this->belongsTo('App\Club');
    }

    public function participants()
    {
        return $this->belongsToMany('App\User', 'users_events')
            ->withTimestamps()
            ->orderBy('name');
    }

    public function anonymousParticipants()
    {
        return $this->belongsToMany('App\AnonymousUser', 'users_events')
            ->withTimestamps()
            ->orderBy('firstname')
            ->orderBy('lastname');
    }
}
