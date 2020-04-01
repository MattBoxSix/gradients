<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gradients extends Model
{
    protected $fillable = [
        'name',
        'color1',
        'color2'
    ];
}
