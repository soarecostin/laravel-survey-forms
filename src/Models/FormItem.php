<?php

namespace SoareCostin\LaravelSurveyForms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormItem extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'form_id', 'sort_order'
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['itemable'];

    public function itemable()
    {
        return $this->morphTo();
    }

    public function form()
    {
        return $this->belongsTo(Form::class, 'form_id');
    }

    public function nextSortIndex()
    {
        if (!$maxSortOrder = self::where('form_id', $this->form_id)->max('sort_order')) {
            return 1;
        }

        return $maxSortOrder + 1;
    }
}
