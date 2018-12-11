<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $table = 'agents';

    protected $fillable = [
        'name',
        'phone',
        'password',
        'province',
        'city',
        'county',
        'address',
        'email',
        'qq',
    ];
}
