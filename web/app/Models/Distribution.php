<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Distribution extends Model
{
    protected $guarded = [];

    protected $casts = [
        'value' => 'array'
    ];
}
