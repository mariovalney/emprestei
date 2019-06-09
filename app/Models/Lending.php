<?php

namespace App\Models;

use App\Support\Model;
use App\Exceptions\ModelInvalidException;

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
     * Validate the model
     *
     * @throws ModelInvalidException
     *
     * @return boolean
     */
    public function validate()
    {
        if (empty($this->date_start)) {
            throw new ModelInvalidException('A data de início do empréstimo é obrigatória.');
        }

        if (empty($this->date_end)) {
            throw new ModelInvalidException('A data de término do empréstimo é obrigatória.');
        }

        return true;
    }
}
