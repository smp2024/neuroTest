<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormQuestion extends Model
{
     protected $fillable = [
        'form_id', 'question_text', 'question_type', 'options', 'order', 'active'
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
