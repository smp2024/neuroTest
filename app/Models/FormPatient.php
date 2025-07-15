<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormPatient extends Model
{
    protected $fillable = [
        'patient_id',
        'form_id',
        'answers',
        'created_at',
        'updated_at',
        'comments',
        'form_question_id',
        'relative_id',
        'question_id',
        'answered_'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function form()
    {
        return $this->belongsTo(Form::class);
    }
    public function formQuestion()
    {
        return $this->belongsTo(FormQuestion::class, 'form_question_id');
    }
    public function getAnswersAttribute($value)
    {
        return json_decode($value, true);
    }
    public function setAnswersAttribute($value)
    {
        $this->attributes['answers'] = json_encode($value);
    }
    public function getAnsweredAttribute($value)
    {
        return $value ? true : false;
    }
    public function setAnsweredAttribute($value)
    {
        $this->attributes['answered'] = $value ? 1 : 0;
    }

}
