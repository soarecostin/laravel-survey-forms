<?php

namespace SoareCostin\LaravelSurveyForms\Tests\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'venue', 'address',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)
                    ->using(EventUser::class)
                    ->withPivot(['id', 'user_id', 'event_id']);
    }
}
