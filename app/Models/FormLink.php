<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormLink extends Model
{
    protected $fillable = ['patient_id', 'relative_id', 'form_id', 'token', 'expires_at', 'used_at',  ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function relative()
    {
        return $this->belongsTo(PatientPerson::class, 'relative_id');
    }

    public function isValid()
    {
        return !$this->used && $this->expires_at > now();
    }

    public function isExpired(): bool
    {
        return $this->expires_at && now()->gt($this->expires_at);
    }

    public function isUsed(): bool
    {
        return !is_null($this->used_at);
    }

    public function person()
    {
        return $this->belongsTo(PatientPerson::class, 'patient_person_id');
    }

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function markAsUsed()
    {
        $this->used_at = now();
        $this->save();
    }
    public function scopeValid($query)
    {
        return $query->where('used', false)
                     ->where('expires_at', '>', now());
    }

}
