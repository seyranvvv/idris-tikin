<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'sliders';

    protected $fillable = [
        'name',
        'link',
        'image',
    ];
}