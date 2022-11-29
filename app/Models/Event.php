<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Event extends Model
{
    use HasFactory;

    protected $appends = [
        'participate',
        'count_participants'
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class, 'event_id', 'id');
    }

    public function getParticipateAttribute()
    {
        if(!is_null(EventUser::where('event_id', $this->id)->where('user_id', Auth::id())->first())) {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getCountParticipantsAttribute()
    {
        return EventUser::where('event_id', $this->id)->count();
    }
}
