<?php

namespace Vehikl\Flip;

use Illuminate\Container\Container;

/**
 * @method boolean enabled(...$params)
 */
abstract class Feature
{
    protected $caller;

    // Maybe it's worth requiring an interface be applied?
    public function __construct($caller)
    {
        $this->caller = $caller;
    }

    public static function new($caller): Feature
    {
        return new static($caller);
    }

    abstract public function toggles(): array;

    public function hasToggle(string $method): bool
    {
        return array_key_exists($method, $this->toggles());
    }

    protected function caller()
    {
        return $this->caller;
    }

    private function methodToCall(string $toggle): string
    {
        $toggles = $this->toggles();

        if (array_key_exists($toggle, $toggles)) {
            // if $toggles was a class, it'd be a lot less error prone.
            $container = new Container;
            return $container->call([$this, 'enabled']) ? $toggles[$toggle]['on'] : $toggles[$toggle]['off'];
        }

        return $toggle;
    }

    public function __call($name, $arguments)
    {
        $methodToCall = $this->methodToCall($name);

        if (method_exists($this, $methodToCall)) {
            return $this->{$methodToCall}(...$arguments);
        }

        // Probably easier to just expect a public method.
        $name = (new \ReflectionClass($this->caller()))->getMethod($methodToCall);
        $name->setAccessible(true);

        return $name->invoke($this->caller(), $arguments);
    }

    public static function __callStatic($method, $arguments)
    {
        // Could be extracted, but I wonder how reliable this would be?
        // Does it really improve the API that much?
        $caller = Caller::guess();

        $instance = new static($caller);

        return $instance->{$method}($arguments);
    }
}
