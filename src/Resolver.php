<?php

namespace Vehikl\Flip;

abstract class Resolver
{
    public function resolve(Feature $feature, string $method)
    {
        return $feature->isAlwaysOn() || $this->_resolve($feature, $method);
    }

    public function _resolve($feature, string $method)
    {
        try {
            return $feature->{$method}();
        } catch (\ArgumentCountError $e) {
            throw new UnresolvableDependencies();
        }
    }
}
