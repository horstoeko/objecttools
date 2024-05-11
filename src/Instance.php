<?php

namespace horstoeko\objecttools;

class Instance
{
    private $className = "";

    private $classConstructorArgs = [];

    private $instance = null;

    public function __construct($classNameOrInstance, ...$classConstructorArgs)
    {
        if (is_null($classConstructorArgs)) {
            $this->className = "unknown";
            $this->classConstructorArgs = $classConstructorArgs;
            $this->instance = null;
        } else if (is_string($classNameOrInstance)) {
            $this->className = $classNameOrInstance;
            $this->classConstructorArgs = $classConstructorArgs;
            $this->makeInstance();
        } else if (is_object($classNameOrInstance)) {
            $this->className = get_class($classNameOrInstance);
            $this->classConstructorArgs = $classConstructorArgs;
            $this->instance = $classNameOrInstance;
        }
    }

    /**
     * Get the real instance
     *
     * @return void
     */
    public function value()
    {
        return $this->instance;
    }

    /**
     * Create an instance of the class
     *
     * @return void
     */
    private function makeInstance()
    {
        if (!class_exists($this->className)) {
            $this->className = "unknown";
            $this->classConstructorArgs = [];
            $this->instance = null;
            return null;
        }

        $this->instance = new $this->className(...$this->classConstructorArgs);
    }

    /**
     * Magic Call
     *
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        if (is_null($this->instance)) {
            return null;
        }

        if (!method_exists($this->instance, $name)) {
            return null;
        }

        return call_user_func_array([$this->instance, $name], $arguments);
    }

    /**
     * Get property
     *
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        if (is_null($this->instance)) {
            return null;
        }

        if (!property_exists($this->instance, $name)) {
            return null;
        }

        return $this->instance->$name;
    }

    /**
     * Set property
     *
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        if (is_null($this->instance)) {
            return null;
        }

        if (!property_exists($this->instance, $name)) {
            return null;
        }

        $this->instance->$name = $value;
    }
}
