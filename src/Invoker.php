<?php

namespace horstoeko\objecttools;

class Invoker
{
    /**
     * The object where methods to invoke
     *
     * @var object|null
     */
    protected $instance = null;

    /**
     * Constructor
     *
     * @param object|null $instance
     */
    protected function __construct(?object $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Create a new Invoker
     *
     * @param  object|null $instance
     * @return Invoker
     */
    public static function factory(?object $instance): Invoker
    {
        return new Invoker($instance);
    }

    /**
     * Returns true, if the instance is set (is not null)
     *
     * @return boolean
     */
    public function instanceIsSet(): bool
    {
        return !is_null($this->instance);
    }

    /**
     * Returns true, if the instance is not set (is null)
     *
     * @return boolean
     */
    public function instanceIsMotSet(): bool
    {
        return !$this->instanceIsSet();
    }

    /**
     * Check existance of a method in $instance
     *
     * @param  string $method
     * @return boolean
     */
    public function methodExists(string $method): bool
    {
        return method_exists($this->instance, $method);
    }

    /**
     * Check that the method $method does not exist in $instance
     *
     * @param  string $method
     * @return boolean
     */
    public function methodNotExists(string $method): bool
    {
        return !$this->methodExists($method);
    }

    /**
     * Try call a method with arguments (if available).
     *
     * @param  string $method
     * @param  mixed  ...$args
     * @return void
     */
    public function callProc(string $method, ...$args): void
    {
        if ($this->instanceIsMotSet()) {
            return;
        }

        if ($this->methodNotExists($method)) {
            return;
        }

        $this->instance->{$method}(...$args);
    }

    /**
     * Try to call the first existing method in $methods array.
     *
     * @param  string[] $methods
     * @param  mixed    ...$args
     * @return void
     */
    public function callProcFirst(array $methods, ...$args): void
    {
        if ($this->instanceIsMotSet()) {
            return;
        }

        $methods =
            array_filter(
                $methods,
                function ($method) {
                    return $this->methodExists($method);
                }
            );

        if (($method = reset($methods)) === false) {
            return;
        }

        $this->instance->{$method}(...$args);
    }

    /**
     * Call a procedure by path (in dot-notation p1.p2). The arguments will be passed to the last call
     *
     * @param  string $path
     * @param  mixed  ...$args
     * @return void
     */
    public function callProcPath(string $path, ...$args): void
    {
        $invoker = $this;
        $methods = array_filter(explode(".", $path));

        foreach ($methods as $index => $method) {
            if ($index == count($methods) - 1) {
                $invoker->callProc($method, ...$args);
            } else {
                $invoker = Invoker::factory($invoker->callFunc($method, ...$args));
            }
        }
    }

    /**
     * Try call a method with arguments (if available). The return value of the called method will be returned.
     *
     * @param  string $method  Method to invoke
     * @param  mixed  ...$args Optional arguments
     * @return mixed|null
     */
    public function callFunc(string $method, ...$args)
    {
        if ($this->instanceIsMotSet()) {
            return null;
        }

        if ($this->methodNotExists($method)) {
            return null;
        }

        return $this->instance->{$method}(...$args);
    }

    /**
     * Try to call the first existing method in $methods array. The return value of the called method will be returned.
     *
     * @param  string[] $methods Array of methods
     * @param  mixed    ...$args Optional arguments
     * @return mixed|null
     */
    public function callFuncFirst(array $methods, ...$args)
    {
        if ($this->instanceIsMotSet()) {
            return null;
        }


        $methods =
            array_filter(
                $methods,
                function ($method) {
                    return $this->methodExists($method);
                }
            );

        if (($method = reset($methods)) === false) {
            return null;
        }

        return $this->instance->{$method}(...$args);
    }

    /**
     * Call a procedure by path (in dot-notation p1.p2). The arguments will be passed to the last call
     *
     * @param  string $path
     * @param  mixed  ...$args
     * @return mixed
     */
    public function callFuncPath(string $path, ...$args)
    {
        $invoker = $this;
        $methods = array_filter(explode(".", $path));

        foreach ($methods as $index => $method) {
            if ($index == count($methods) - 1) {
                return $invoker->callFunc($method, ...$args);
            } else {
                $invoker = Invoker::factory($invoker->callFunc($method, ...$args));
            }
        }

        return null;
    }
}
