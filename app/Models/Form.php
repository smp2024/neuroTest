<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Form extends Model
{
    /** @use HasFactory<\Database\Factories\FormFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'slug', 'description', 'type', 'group'];

    public function questions()
    {
        return $this->hasMany(FormQuestion::class);
    }
}
