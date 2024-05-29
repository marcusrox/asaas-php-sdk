<?php

namespace Adrianovcar\Asaas\Entity;

use DateTime;
use stdClass;

/**
 * Abstract Entity
 *
 * @author Adriano Carrijo <adrianovieirac@gmail.com>
 * @author Agência Softr <agencia.softr@gmail.com>
 */
abstract class AbstractEntity
{
    /**
     * Constructor
     *
     * @param  stdClass|array|null  $parameters  (optional) Entity parameters
     */
    public function __construct($parameters = null)
    {
        if (!$parameters) {
            return;
        }

        if ($parameters instanceof stdClass) {
            $parameters = get_object_vars($parameters);
        }

        $this->build($parameters);
    }

    /**
     * Fill entity with parameters data
     *
     * @param  array  $parameters  Entity parameters
     */
    public function build(array $parameters)
    {
        foreach ($parameters as $property => $value) {
            if (property_exists($this, $property)) {
                $this->$property = $value;

                // Apply mutator

                $mutator = 'set'.ucfirst(static::convertToCamelCase($property));

                if (method_exists($this, $mutator)) {
                    call_user_func_array(array($this, $mutator), [$value]);
                }
            }
        }
    }

    /**
     * Convert to CamelCase
     *
     * @param  string  $str  Snake case string
     * @return  string  Camel case string
     */
    protected static function convertToCamelCase(string $str): string
    {
        $callback = function ($match) {
            return strtoupper($match[2]);
        };

        return lcfirst(preg_replace_callback('/(^|_)([a-z])/', $callback, $str));
    }

    /**
     * Convert date string do DateTime Object
     *
     * @param  string|null  $date  DateTime string
     * @return DateTime|null
     */
    protected static function convertDateTime(string $date): ?DateTime
    {
        if (!$date) {
            return null;
        }

        $date = DateTime::createFromFormat('d/m/Y', $date);

        if (!$date) {
            return null;
        }

        return $date;
    }
}
