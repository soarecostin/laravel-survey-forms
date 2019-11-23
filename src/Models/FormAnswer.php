<?php

namespace SoareCostin\LaravelSurveyForms\Models;

use Illuminate\Database\Eloquent\Model;
use SoareCostin\LaravelSurveyForms\Models\FormItems\Field;

class FormAnswer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'field_id', 'field_name', 'value'
    ];

    public function field()
    {
        return $this->belongsTo(Field::class);
    }

    public function response()
    {
        return $this->belongsTo(FormResponse::class);
    }

    public function getValueAttribute($value)
    {
        if (is_array($jsonArray = json_decode($value, true))) {
            return $jsonArray;
        }

        return $value;
    }
}
