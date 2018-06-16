<?php

namespace Vehikl\Flip\Tests\Unit;

use Vehikl\Flip\Flip;
use PHPUnit\Framework\TestCase;
use Vehikl\Flip\Tests\SomeClass;
use Vehikl\Flip\Tests\SomeFeature;
use Vehikl\Flip\Tests\SomeOtherFeature;

class FlipTest extends TestCase
{
    public function test_it_calls_feature_methods()
    {
        $flip = new Flip(new SomeClass, [SomeFeature::class]);

        $this->assertEquals('whenOff', $flip->someToggle());
    }

    public function test_it_calls_methods_on_the_class_if_there_are_no_applicable_features()
    {
        $flip = new Flip(new SomeClass, [SomeFeature::class]);

        $this->assertEquals('going!', $flip->go());
    }

    public function test_it_can_select_the_correct_toggle_to_run_from_multiple_features()
    {
        $flip = new Flip(new SomeClass, [SomeFeature::class, SomeOtherFeature::class]);

        $this->assertEquals('whenSomeOtherToggleIsOn', $flip->someOtherToggle());
    }

    public function test_the_flip_trait_makes_calling_features_easier()
    {
        $someClass = new SomeClass;

        $this->assertEquals('whenSomeOtherToggleIsOn', $someClass->someToggledMethod());
    }
}
