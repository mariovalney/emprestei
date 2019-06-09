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

    /**
     * Delete the Model
     */
    public function delete()
    {
        $thing = $this->getThing();
        $lender = $this->getLender();

        $result = parent::delete();
        if ($result) {
            $thing->delete();
            $lender->delete();
        }

        return $result;
    }

    /**
     * Get the thing or a empty object
     *
     * @return object
     */
    public function getThing()
    {
        if (! empty($this->thing_id)) {
            $thing = Thing::find($this->thing_id);
            if (! empty($thing)) {
                return $thing;
            }
        }

        return (object) [];
    }

    /**
     * Get the lender or a empty object
     *
     * @return object
     */
    public function getLender()
    {
        if (! empty($this->lender_id)) {
            $lender = Lender::find($this->lender_id);
            if (! empty($lender)) {
                return $lender;
            }
        }

        return (object) [];
    }
}
