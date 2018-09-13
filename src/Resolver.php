<?php

namespace Vehikl\Flip;

abstract class Resolver
{
    public function resolve(Feature $feature, string $method)
    {
        if ($feature->hasForcedState()) {
            return $feature->isAlwaysOn();
        }

        return $this->call($feature, $method);
    }

    protected function call($feature, string $method)
    {
        try {
            return $feature->{$method}();
        } catch (\ArgumentCountError $e) {
            throw new UnresolvableDependencies();
        }
    }
}
