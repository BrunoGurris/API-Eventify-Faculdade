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
        'count_participants',
        'rating',
        'rating_me'
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class, 'event_id', 'id')->orderBy('id', 'desc');
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

    public function getRatingAttribute()
    {
        $division = EventUserRating::where('event_id', $this->id)->count();

        if($division == 0) {
            $division = 1;
        }

        return number_format(floatval(EventUserRating::where('event_id', $this->id)->sum('rating') / $division), 2, ',', '.');
    }

    public function getRatingMeAttribute()
    {
        $rating = EventUserRating::where('event_id', $this->id)->where('user_id', Auth::id())->first();

        if($rating) {
            return $rating->rating;
        }
        else
        {
            return 0;
        }
    }
}
