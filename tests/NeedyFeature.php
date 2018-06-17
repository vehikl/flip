<?php

namespace Vehikl\Flip\Tests;

use Vehikl\Flip\Feature;

class NeedyFeature extends Feature
{
    public function toggles(): array
    {
        return [
            'toggle' => [
                'on' => 'whenToggleIsOn',
                'off' => 'whenToggleIsOff'
            ]
        ];
    }

    public function enabled(SomeDependency $dependency): bool
    {
        $dependency::$injected = true;

        return true;
    }

    public function whenToggleIsOn(): void
    {
    }

    public function whenToggleIsOff(): void
    {
    }
}
