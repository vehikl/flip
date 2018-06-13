<?php

namespace Vehikl\Flip;

class Flip
{
    private $class;
    private $features;

    public function __construct(object $class, array $features = [])
    {
        $this->class = $class;
        $this->features = $features;
    }

    private function applicableFeature(string $method): ?Feature
    {
        // Probably want a factory class to resolve any dependencies and cache
        foreach ($this->buildFeatures() as $feature) {
            if ($feature->hasToggle($method)) {
                return $feature;
            }
        }

        return null;
    }

    /**
     * @return \Generator|Feature[]
     */
    private function buildFeatures(): \Generator
    {
        foreach ($this->features as $feature) {
            yield new $feature($this->class);
        }
    }

    public function __call($method, $arguments)
    {
        // What happens if a method applies to multiple features?
        $first = $this->applicableFeature($method) ?: $this->class;

        return $first->{$method}($arguments);
    }
}
