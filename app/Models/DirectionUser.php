<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DirectionUser extends Model
{
    use HasFactory;
    protected $table = 'direction_users';

    protected $fillable = [
        'user_id',
        'street',
        'number',
        'colony',
        'postal_code',
        'city',
        'state',
        'country',
        'references',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
