<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    public function medico()
{
    return $this->belongsTo(User::class, 'specialitie_id');
}

public function citasHoy()
{
    return $this->hasMany(Appointment::class)->whereDate('date_appointment', now());
}
}
