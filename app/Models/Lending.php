<?php

namespace App\Models;

use App\Support\Model;

class Lending extends Model
{
    /**
     * Field of Model
     *
     * @var array
     */
    protected $fillable = [
        'thing_id',
        'lender_id',
        'date_start',
        'date_end',
    ];

    /**
     * Default Attributes
     *
     * @var array
     */
    protected $attributes = [
        'date_start' => date('Y-m-d H:i:s'),
    ];
}
