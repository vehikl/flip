<?php

namespace Vehikl\Flip;

class DefaultResolver implements Resolver
{
    public function resolve($object, string $method)
    {
        try {
            return $object->{$method}();
        } catch (\ArgumentCountError $e) {
            throw new UnresolvableDependencies();
        }
    }
}
