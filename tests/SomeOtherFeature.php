<?php

namespace Vehikl\Flip\Tests;

use Vehikl\Flip\Feature;

class SomeOtherFeature extends Feature
{
    protected static $forceState;

    private $invokedMethod;
    private $enabled = true;

    public function toggles(): array
    {
        return [
            'someOtherToggle' => [
                'on' => 'whenSomeOtherToggleIsOn',
                'off' => 'whenSomeOtherToggleIsOff'
            ]
        ];
    }

    public function turnOff() : void
    {
        $this->enabled = false;
    }

    public function turnOn() : void
    {
        $this->enabled = true;
    }

    public function enabled(): bool
    {
        return $this->enabled;
    }

    public function whenSomeOtherToggleIsOn() : string
    {
        return $this->invokedMethod = 'whenSomeOtherToggleIsOn';
    }

    public function whenSomeOtherToggleIsOff() : string
    {
        return $this->invokedMethod = 'whenSomeOtherToggleIsOff';
    }

    public function invokedMethod() : string
    {
        return $this->invokedMethod;
    }
}
