<?php

namespace SoareCostin\LaravelSurveyForms\Tests\Models;

use SoareCostin\LaravelSurveyForms\Traits\HasSurveys;
use Illuminate\Database\Eloquent\Relations\Pivot;

class EventUser extends Pivot
{
    use HasSurveys;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_id', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
