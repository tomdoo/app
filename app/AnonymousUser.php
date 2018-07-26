<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnonymousUser extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function events()
    {
        return $this->belongsToMany('App\Event', 'users_events')
            ->withTimestamps();
    }
}
