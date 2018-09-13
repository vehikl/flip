<?php

namespace Vehikl\Flip\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Vehikl\Flip\DefaultResolver;
use Vehikl\Flip\Tests\SomeFeature;
use Vehikl\Flip\UnresolvableDependencies;

class DefaultResolverTest extends TestCase
{
    public function test_it_calls_methods_which_do_not_have_dependencies()
    {
        $someFeature = new SomeFeature($this);
        $someFeature->turnOn();

        $this->assertEquals('whenOn', (new DefaultResolver)->resolve($someFeature, 'someToggle'));
    }

    public function test_it_throws_an_exception_when_the_resolved_method_does_have_dependencies()
    {
        $this->expectException(UnresolvableDependencies::class);
        $this->expectExceptionMessage("The Flip DefaultResolver is unable to resolve method dependencies.");

        $someFeature = new SomeFeature($this);
        (new DefaultResolver)->resolve($someFeature, 'someRequiredParameterAcceptingToggle');
    }
}
