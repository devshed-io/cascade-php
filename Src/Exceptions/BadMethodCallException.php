<?php


namespace Devshed\Cascade\Exceptions;


class BadMethodCallException extends \BadMethodCallException
{
    /**
     * @param string $method
     *
     * @return static
     */
    public static function badMethodCall(string $method)
    {
        return new static(sprintf('Call to undefined method [%s] on cascade', $method));
    }
}