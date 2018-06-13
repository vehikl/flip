<?php

namespace Vehikl\Flip\Tests\Unit;

use PHPUnit\Framework\TestResult;
use Vehikl\Flip\Feature;
use PHPUnit\Framework\TestCase;

class FeatureTest extends TestCase
{
    public function test_static_new_returns_new_instance()
    {
        $this->assertInstanceOf(SomeFeature::class, SomeFeature::new($this));
    }

    public function test_features_know_which_toggles_they_have()
    {
        $this->assertTrue((new SomeFeature($this))->hasToggle('someToggle'));
        $this->assertFalse((new SomeFeature($this))->hasToggle('missingToggle'));
    }

    public function test_toggles_execute_the_on_method_when_the_feature_is_enabled()
    {
        $feature = SomeFeature::new($this)->turnOn();
        $feature->someToggle();

        $this->assertEquals('whenOn', $feature->invokedMethod());
    }

    public function test_toggles_execute_the_off_method_when_the_feature_is_disabled()
    {
        $feature = SomeFeature::new($this)->turnOff();
        $feature->someToggle();

        $this->assertEquals('whenOff', $feature->invokedMethod());
    }

    public function test_feature_toggles_can_call_public_methods_on_the_class_they_are_mixed_into()
    {
        $feature = SomeFeature::new($this)->turnOn();
        $this->assertEquals(__METHOD__, $feature->anotherToggle());
    }

    public function test_feature_toggles_can_call_protected_methods_on_the_class_they_are_mixed_into()
    {
        $feature = SomeFeature::new($this)->turnOff();
        $this->assertInstanceOf(TestResult::class, $feature->anotherToggle());
    }

    public function test_feature_toggles_can_be_called_statically()
    {
        $this->assertSame($this, SomeFeature::staticToggle());
    }
}

class SomeFeature extends Feature
{
    private $enabled = false;
    private $invokedMethod;

    public function toggles(): array
    {
        return ['someToggle' => ['on' => 'whenSomeToggleIsOn', 'off' => 'whenSomeToggleIsOff'], 'anotherToggle' => ['on' => 'whenAnotherToggleIsOn', 'off' => 'whenAnotherToggleIsOff',], 'staticToggle' => ['on' => 'whenStaticToggleIsOn', 'off' => 'whenStaticToggleIsOff',],];
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

    public function whenSomeToggleIsOn(): void
    {
        $this->invokedMethod = 'whenOn';
    }

    public function whenSomeToggleIsOff(): void
    {
        $this->invokedMethod = 'whenOff';
    }

    public function invokedMethod(): string
    {
        return $this->invokedMethod;
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
}
