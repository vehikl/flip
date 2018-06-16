<?php

namespace Vehikl\Flip\Tests;

use Vehikl\Flip\Feature;

class SomeOtherFeature extends Feature
{
    public function toggles(): array
    {
        return ['someOtherToggle' => ['on' => 'whenSomeOtherToggleIsOn', 'off' => 'whenSomeOtherToggleIsOff']];
    }

    public function enabled(): bool
    {
        return true;
    }

    public function whenSomeOtherToggleIsOn()
    {
        return 'whenSomeOtherToggleIsOn';
    }

    public function whenSomeOtherToggleIsOff()
    {
        return 'whenSomeOtherToggleIsOff';
    }
}
