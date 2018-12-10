<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TemplateType extends Model
{
    protected $table = 'template_types';

    protected $fillable = [
        'name',
        'introduce',
        'logo',
        'detail_picture',
    ];
}
