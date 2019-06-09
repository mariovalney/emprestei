<?php

namespace App\Support\Helpers;

use App\Support\Facades\Request;

class FormBuilder
{
    /** @var mixed  */
    private static $model;

    /**
     * Set a model
     *
     * @param  mixed $model
     * @return void
     */
    public function model($model)
    {
        $this::$model = $model;
    }

    /**
     * Echoes form Label
     *
     * @param  string $label
     * @param  string $for
     * @param  array  $attributes
     * @return string
     */
    public function label($label, $for = '', $attributes = [])
    {
        $attributes['for'] = $for;
        echo '<label ' . $this->attributes($attributes) . '>' . $label . '</label>';
    }

    /**
     * Echoes a form input
     *
     * @see FormBuilder::prepareInputAttributes()
     *
     * @param  string  $type
     * @return string
     */
    public function input($type, $name, $property = null, $required = false, $attributes = [])
    {
        $attributes = $this->prepareInputAttributes($name, $property, $required, $attributes);
        $attributes['type'] = $type;

        echo '<input ' . $this->attributes($attributes) . '>';
    }

    /**
     * Echoes a textarea input
     *
     * @see FormBuilder::prepareInputAttributes()
     *
     * @return string
     */
    public function textarea($name, $property = null, $required = false, $attributes = [])
    {
        $attributes = $this->prepareInputAttributes($name, $property, $required, $attributes);
        $value = $attributes['value'] ?? '';
        unset($attributes['value']);

        echo '<textarea ' . $this->attributes($attributes) . '>' . $value . '</textarea>';
    }

    /**
     * Echoes a select input
     *
     * @see FormBuilder::prepareInputAttributes()
     *
     * @return string
     */
    public function select($options, $name, $property = null, $required = false, $attributes = [])
    {
        $attributes = $this->prepareInputAttributes($name, $property, $required, $attributes);
        $selected = $attributes['value'] ?? '';
        unset($attributes['value']);

        // Check is associative array
        if (array_keys($options) === range(0, count($options) - 1)) {
            $values = array_values($options);
            $options = array_combine($values, $values);
        }

        echo '<select ' . $this->attributes($attributes) . '>';
        foreach ($options as $optionValue => $optionLabel) {
            $optionAttributes = ['value' => $optionValue];
            if ($selected == $optionValue) {
                $optionAttributes['selected'] = 'selected';
            }

            echo '<option ' . $this->attributes($optionAttributes) . '>' . $optionLabel . '</option>';
        }
        echo '</select>';
    }

    /**
     * Prepare the input attributes
     *
     * @param  string  $name       The input name
     * @param  string  $property   The property of model (@see FormBuilder::model)
     * @param  boolean $required   True if it's required
     * @param  array   $attributes A array of attributes (will be override by method properties)
     * @return string
     */
    private function prepareInputAttributes($name, $property = null, $required = false, $attributes = [])
    {
        if (empty($property)) {
            $property = $name;
        }

        $attributes['name'] = $name;
        $attributes['id'] = $attributes['id'] ?? $name;

        if ($required) {
            $attributes['required'] = 'required';
        }

        // Try value from Request
        $old = Request::input($attributes['name']);
        if (! is_null($old)) {
            $attributes['value'] = $old;
        }

        // Try value from Model
        if (empty($attributes['value']) && ! empty($this::$model) && isset($this::$model->{$property})) {
            $attributes['value'] = $this::$model->{$property};
        }

        return $attributes;
    }

    /**
     * Turn a array into HTML attributes
     *
     * @param  array  $attributes
     * @return string
     */
    private function attributes($attributes = [])
    {
        foreach ($attributes as $key => $value) {
            $attributes[ $key ] = $key . '="' . $value . '"';
        }

        return implode(' ', $attributes);
    }
}
