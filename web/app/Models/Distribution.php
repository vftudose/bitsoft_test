<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Distribution extends Model
{
    protected array $guarded = [];

    protected $casts = [
        'value' => 'array'
    ];
}