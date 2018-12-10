<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WxCase extends Model
{
    protected $table = 'cases';

    protected $fillable = [
        'name',
        'qr_code',
    ];
}
