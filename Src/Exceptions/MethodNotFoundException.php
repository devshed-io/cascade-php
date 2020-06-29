<?php


namespace Devshed\Cascade\Exceptions;


use Exception;

class MethodNotFoundException extends Exception
{
    /**
     * @param string $class
     *
     * @return static
     */
    public static function noCascadeMethodFound(string $class)
    {
        return new static(sprintf('No cascade method found in stage class %s', $class));
    }
}