<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    public function paciente()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }
}
