<?php

namespace Vehikl\Flip\Tests\Unit;

use Illuminate\Container\Container;
use PHPUnit\Framework\TestResult;
use PHPUnit\Framework\TestCase;
use Vehikl\Flip\Feature;
use Vehikl\Flip\Tests\NeedyFeature;
use Vehikl\Flip\Tests\SomeDependency;
use Vehikl\Flip\Tests\SomeFeature;

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

    public function test_toggles_executes_the_on_method_when_the_feature_is_enabled()
    {
        $feature = SomeFeature::new($this)->turnOn();
        $feature->someToggle();

        $this->assertEquals('whenOn', $feature->invokedMethod());
    }

    public function test_toggles_executes_the_off_method_when_the_feature_is_disabled()
    {
        $feature = SomeFeature::new($this)->turnOff();
        $feature->someToggle();

        $this->assertEquals('whenOff', $feature->invokedMethod());
    }

    public function test_features_pass_method_parameters_to_toggles()
    {
        $feature = SomeFeature::new($this)->turnOn();
        $feature->someParameterAcceptingToggle('param1', 'param2');

        $this->assertEquals(['param1', 'param2'], $feature->parameters());
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

    public function test_it_blows_up_when_trying_to_use_a_toggle_that_doesnt_exist()
    {
        $this->expectException(\ReflectionException::class);
        $this->expectExceptionMessage('Method nope does not exist');

        SomeFeature::new($this)->nope();
    }

    public function test_it_blows_up_when_a_toggle_method_calls_a_method_that_doesnt_exist()
    {
        $this->expectException(\ReflectionException::class);
        $this->expectExceptionMessage('Method nope does not exist');

        SomeFeature::new($this)->bustedToggle();
    }

    public function test_a_features_enabled_method_is_passed_the_parameters_it_depends_on()
    {
        $needyFeature = new NeedyFeature($this);

        $this->assertFalse(SomeDependency::$injected);

        $needyFeature->toggle();

        $this->assertTrue(SomeDependency::$injected);
    }

    public function test_a_container_can_be_registered_with_the_feature()
    {
        $container = new Container;
        Feature::registerContainer($container);
        $someFeature = new SomeFeature($this);

        $this->assertSame($container, $someFeature->container());
    }

    public function test_a_new_container_is_registered_by_default()
    {
        $someFeature = new SomeFeature($this);

        $this->assertInstanceOf(Container::class, $someFeature->container());
    }

    public function test_the_same_container_is_always_returned()
    {
        $someFeature = new SomeFeature($this);
        $container = $someFeature->container();

        $this->assertSame($container, $someFeature->container());
    }
}
