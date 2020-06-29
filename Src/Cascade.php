<?php

namespace Devshed\Cascade;

use Devshed\Cascade\Exceptions\BadMethodCallException;
use Devshed\Cascade\Exceptions\MethodNotFoundException;

/**
 * @method static Cascade send(string $string)
 * @method Cascade over(string $class)
 */
class Cascade
{
    /**
     * @var string[]|\Closure[]
     */
    public $levels = [];
    /**
     * @var mixed|null
     */
    protected $value;

    /**
     * Cascade constructor.
     *
     * @param mixed $value
     */
    public function __construct($value = null)
    {
        $this->value = $value;
    }

    /**
     * Allow static method overloading
     *
     * @param $name
     * @param $arguments
     *
     * @return static
     */
    public static function __callStatic($name, $arguments)
    {
        $method = 'call' . ucfirst($name);

        if (method_exists(static::class, $method)) {
            return static::make()->$method(...$arguments);
        } else {
            throw BadMethodCallException::badMethodCall($name);
        }
    }

    /**
     * @return static
     */
    protected static function make()
    {
        return new static;
    }

    /**
     * Push a stage to the cascade
     *
     * @param $class
     *
     * @return $this
     */
    public function callOver($class)
    {
        $this->levels[] = $class;

        return $this;
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function callSend($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Run the cascade
     *
     * @return $this
     *
     * @throws \Devshed\Cascade\Exceptions\MethodNotFoundException
     */
    public function run()
    {
        foreach ($this->levels as $level) {
            $instance = new $level();

            if (!method_exists($instance, 'cascade')) { // Todo: Dynamic method name
                throw MethodNotFoundException::noCascadeMethodFound($level);
            }

            $instance->cascade($this->value, function ($value) {
                $this->value = $value;
            });
        }

        return $this;
    }

    /**
     * @return mixed|null
     */
    public function output()
    {
        return $this->value;
    }

    /**
     * Allow non-static method overloading
     *
     * @param $name
     * @param $arguments
     *
     * @return static
     */
    public function __call($name, $arguments)
    {
        $method = 'call' . ucfirst($name);

        if (method_exists($this, $method)) {
            return $this->$method(...$arguments);
        } else {
            throw BadMethodCallException::badMethodCall($name);
        }
    }
}