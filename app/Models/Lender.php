<?php

namespace App\Models;

use App\Support\Model;
use App\Exceptions\ModelInvalidException;

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

    /**
     * Validate the model
     *
     * @throws ModelInvalidException
     *
     * @return boolean
     */
    public function validate()
    {
        if (empty($this->name)) {
            throw new ModelInvalidException('O nome de quem está recebendo o empréstimo é obrigatório.');
        }

        if (empty($this->email) && empty($this->phone)) {
            throw new ModelInvalidException('Uma forma de contato (e-mail ou telefone) para quem está recebendo o empréstimo é obrigatória.');
        }

        return true;
    }
}
