<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\PatientPerson;
use App\Models\FormPatient;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
     use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'surname', 'email', 'mobile', 'gender',
        'education', 'address', 'birth_date', 'n_document',
        'avatar', 'antecedent_family', 'antecedent_personal',
        'antecedent_allergic', 'pa', 'temperatura', 'fc',
        'fr', 'ta', 'peso', 'current_disease'
    ];

    public function setCreatedAtAttribute($value)
    {
    	date_default_timezone_set('America/Chihuahua');
        $this->attributes["created_at"]= Carbon::now();
    }

    public function setUpdatedAtAttribute($value)
    {
    	date_default_timezone_set('America/Chihuahua');
        $this->attributes["updated_at"]= Carbon::now();
    }
    public function relatives() {
        return $this->hasMany(PatientPerson::class);
    }

    public function answers() {
        return $this->hasMany(FormPatient::class);
    }

    public function getPersons() {
        return $this->hasMany(PatientPerson::class, 'patient_id');
    }

    public function getDirection() {
        return $this->hasOne(DirectionUser::class, 'patient_id');
    }
    public function getFormLink() {
        return $this->hasOne(FormPatient::class, 'patient_id');
    }

}
