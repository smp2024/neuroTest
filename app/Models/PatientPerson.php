<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientPerson extends Model
{
    use SoftDeletes;

    protected $table = 'patient_persons';

    protected $fillable = [
        'patient_id',
        'type_person',
        'name_companion',
        'surname_companion',
        'email_companion',
        'mobile_companion',
        'relationship_companion',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
    public function getPatient()
    {
        return $this->hasOne(Patient::class, 'patient_id');
    }

    public function formLink()
    {
        return $this->hasOne(FormLink::class, 'relative_id');
    }
}
