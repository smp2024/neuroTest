<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PostalCode extends Model
{
    use  HasFactory, Notifiable;
    protected $fillable = [
        'postal_code',
        'colony',
        'municipality',
        'state',
        'colony_normalice',
        'municipality_normalice',
    ];
    // protected $table = 'postal_codes';
    protected $primaryKey = 'id';

}
