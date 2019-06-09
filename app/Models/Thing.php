<?php

namespace App\Models;

use App\Support\Facades\Database;
use App\Support\Model;
use App\Exceptions\ModelInvalidException;

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
        'note',
    ];

    /**
     * Default Attributes
     *
     * @var array
     */
    protected $attributes = [
        'type' => '',
        'note' => '',
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
            throw new ModelInvalidException('O nome do objeto é obrigatório.');
        }

        if (empty($this->type)) {
            throw new ModelInvalidException('O tipo do objeto é obrigatório.');
        }

        return true;
    }

    /**
     * Get all types on database
     * @return array
     */
    public static function getAllTypes()
    {
        $types = [];
        $results = Database::select('things', [], 'DISTINCT(type)');
        foreach ($results as $result) {
            $types[] = $result['type'];
        }

        return $types;
    }
}
