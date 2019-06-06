<?php

namespace App\Models;

use App\Support\Model;

class Thing extends Model
{
    /**
     * Field of Model
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'type',
        'description',
    ];

    /**
     * Default Attributes
     *
     * @var array
     */
    protected $attributes = [
        'type' => '',
        'description' => '',
    ];
}
