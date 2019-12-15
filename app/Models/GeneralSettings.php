<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralSettings extends Model
{
    protected $fillable = [
        'name', 'email', 'language', 'theme', 'logo'
    ];

    
}
