<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name', 'description', 'start_date', 'end_date', 'location'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'project_users')->withPivot('role');
    }


}
