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
        'answered'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
