<?php

namespace SoareCostin\LaravelSurveyForms\Models;

use Illuminate\Database\Eloquent\Model;
use SoareCostin\LaravelSurveyForms\Models\Form;

class FormResponse extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'form_id', 'formable_id', 'formable_type'
    ];

    public function form()
    {
        return $this->belongsTo(Form::class, 'form_id');
    }

    public function formable()
    {
        return $this->morphTo();
    }

    public function answers()
    {
        return $this->hasMany(FormAnswer::class);
    }
}
