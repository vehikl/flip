<?php

namespace Vehikl\Flip;

interface Resolver
{
    public function resolve($object, string $method);
}
