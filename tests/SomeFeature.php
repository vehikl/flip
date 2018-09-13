<?php

namespace Vehikl\Flip\Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\TestResult;
use Vehikl\Flip\Feature;

class SomeFeature extends Feature
{
    private $enabled = false;
    private $invokedMethod;
    private $parameters;

    public function toggles(): array
    {
        return [
            'someToggle' => [
                'on' => 'whenSomeToggleIsOn',
                'off' => 'whenSomeToggleIsOff'
            ],
            'anotherToggle' => [
                'on' => 'whenAnotherToggleIsOn',
                'off' => 'whenAnotherToggleIsOff'
            ],
            'staticToggle' => [
                'on' => 'whenStaticToggleIsOn',
                'off' => 'whenStaticToggleIsOff'
            ],
            'bustedToggle' => [
                'on' => 'whenBustedToggleIsOn',
                'off' => 'whenBustedToggleIsOff'
            ],
            'someParameterAcceptingToggle' => [
                'on' => 'whenSomeParameterAcceptingToggleIsOn',
                'off' => 'whenSomeParameterAcceptingToggleIsOff'
            ],
            'someRequiredParameterAcceptingToggle' => [
                'on' => 'whenSomeRequiredParameterAcceptingToggleIsOn',
                'off' => 'whenSomeRequiredParameterAcceptingToggleIsOff'
            ],
        ];
    }

    public function enabled(): bool
    {
        return $this->enabled;
    }

    public function turnOn(): self
    {
        $this->enabled = true;

        return $this;
    }

    public function turnOff(): self
    {
        $this->enabled = false;

        return $this;
    }

    public function whenSomeToggleIsOn(): string
    {
        return $this->invokedMethod = 'whenOn';
    }

    public function whenSomeToggleIsOff(): string
    {
        return $this->invokedMethod = 'whenOff';
    }

    public function invokedMethod(): string
    {
        return $this->invokedMethod;
    }

    public function parameters()
    {
        return $this->parameters;
    }

    public function whenAnotherToggleIsOn(): string
    {
        return $this->toString();
    }

    public function whenAnotherToggleIsOff(): TestResult
    {
        return $this->createResult();
    }

    public function whenStaticToggleIsOn(): void
    {
    }

    public function whenStaticToggleIsOff(): TestCase
    {
        return $this->caller;
    }

    public function whenBustedToggleIsOn(): void
    {
    }

    public function whenBustedToggleIsOff(): void
    {
        $this->nope();
    }

    public function whenSomeParameterAcceptingToggleIsOn(...$params): void
    {
        $this->parameters = $params;
    }

    public function whenSomeParameterAcceptingToggleIsOff(...$params): void
    {
        $this->parameters = $params;
    }

    public function whenSomeRequiredParameterAcceptingToggleIsOn($someParameter) : void
    {
    }

    public function whenSomeRequiredParameterAcceptingToggleIsOff($someParameter) : void
    {
    }
}
