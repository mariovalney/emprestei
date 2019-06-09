<?php

namespace App\Support;

use App\Support\Facades\Database;
use App\Support\Doctrine\Inflector;

class Model
{
    /**
     * The identifier column
     *
     * @var string
     */
    protected static $identifier = 'ID';

    /**
     * Field of Model
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * Attributes of Model
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Create a new Model
     */
    public function __construct(array $attributes = [])
    {
        foreach ($attributes as $key => $value) {
            if ($key === static::$identifier) {
                $this->{static::$identifier} = $value;
                continue;
            }

            if (! in_array($key, $this->fillable, true)) {
                continue;
            }

            $this->attributes[ $key ] = $value;
        }
    }

    /**
     * Magic method to get attributes
     *
     * @param  string $name
     * @return mixed
     */
    public function __get(string $name)
    {
        return $this->attributes[ $name ] ?? null;
    }

    /**
     * Magic method to set attributes
     *
     * @param  string $name
     * @return mixed
     */
    public function __set(string $name, $value)
    {
        if ($name === static::$identifier) {
            $this->{static::$identifier} = $value;
            return;
        }

        if (! in_array($name, $this->fillable)) {
            return;
        }

        $this->attributes[ $name ] = $value;
    }

    /**
     * Magic method to check a attribute isseted
     *
     * @param  string $name
     * @return mixed
     */
    public function __isset($key)
    {
        $value = $this->__get($key);

        return isset($key);
    }

    /**
     * Validate the model
     *
     * @throws ModelInvalidException
     *
     * @return boolean
     */
    public function validate()
    {
        return true;
    }

    /**
     * Create or update a new registry on database
     */
    public function save()
    {
        $identifier = $this->{static::$identifier};
        if (empty($identifier)) {
            return Database::insert(static::getTable(), $this->attributes);
        }

        $where = [static::$identifier => $identifier];
        $result = Database::update(static::getTable(), $this->attributes, $where);

        return ($result) ? $identifier : 0;
    }

    /**
     * Remove a registry from database
     */
    public function delete()
    {
        $identifier = $this->{static::$identifier};
        $where = [static::$identifier => $identifier];

        return Database::delete(static::getTable(), $where);
    }

    /**
     * Retrieve a single registry from database
     *
     * @param  string $identifier
     *
     * @return Model
     */
    public static function find($identifier)
    {
        $where = [static::$identifier => $identifier];
        $result = Database::select(static::getTable(), $where);

        if (empty($result)) {
            return false;
        }

        return new static($result[0]);
    }

    /**
     * Retrieve all registries from database
     *
     * @return Model
     */
    public static function all()
    {
        $results = Database::select(static::getTable());

        foreach ($results as $key => $result) {
            $results[ $key ] = new static($result);
        }

        return $results;
    }

    /**
     * Get table name of model
     *
     * @return string
     */
    private static function getTable()
    {
        if (! empty(static::$table)) {
            return static::$table;
        }

        $table = static::class;
        $table = explode('\\', $table);
        $table = strtolower(array_pop($table));

        $table = Inflector::pluralize($table);

        return $table;
    }
}
