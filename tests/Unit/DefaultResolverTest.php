<?php

namespace Vehikl\Flip\Tests\Unit;

use Vehikl\Flip\DefaultResolver;
use PHPUnit\Framework\TestCase;
use Vehikl\Flip\Tests\SomeDependency;
use Vehikl\Flip\UnresolvableDependencies;

class DefaultResolverTest extends TestCase
{
    public function test_it_calls_methods_which_do_not_have_dependencies()
    {
        $class = new class() {
            public function someMethod()
            {
                return true;
            }
        };

        $this->assertTrue((new DefaultResolver)->resolve($class, 'someMethod'));
    }

    public function test_it_throws_an_exception_when_the_resolved_method_does_have_dependencies()
    {
        $class = new class() {
            public function someMethod(SomeDependency $someDependency)
            {
                return false;
            }
        };

        $this->expectException(UnresolvableDependencies::class);
        $this->expectExceptionMessage("The Flip DefaultResolver is unable to resolve method dependencies.");

        (new DefaultResolver)->resolve($class, 'someMethod');
    }
}
