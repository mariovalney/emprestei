<?php

namespace App\Models;

use App\Support\Model;

class Lender extends Model
{
    /**
     * Field of Model
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
    ];

    /**
     * Default Attributes
     *
     * @var array
     */
    protected $attributes = [
        'name' => '',
        'email' => '',
        'phone' => '',
    ];
}
