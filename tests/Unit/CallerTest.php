<?php

namespace Vehikl\Flip\Tests\Unit {

    use Vehikl\Flip\Caller;
    use PHPUnit\Framework\TestCase;
    use Vehikl\Flip\Feature;

    class CallerTest extends TestCase
    {
        protected function tearDown()
        {
            global $trace;
            $trace = null;

            parent::tearDown();
        }

        public function test_guess_finds_this_object()
        {
            $this->assertSame($this, Caller::guess());
        }

        public function test_guess_throws_a_logic_exception_when_the_caller_cant_be_found()
        {
            global $trace;
            $trace = [];

            $this->expectException(\LogicException::class);
            $this->expectExceptionMessage('No caller found.');

            Caller::guess();
        }

        public function test_guess_ignores_feature_classes()
        {
            $feature = new class($this) extends Feature {
                public function toggles(): array
                {
                    return [];
                }

                public function enabled(): bool
                {
                    return false;
                }

                public function go()
                {
                    return Caller::guess();
                }
            };

            $this->assertSame($this, $feature->go());
        }
    }
}

namespace Vehikl\Flip {

    function debug_backtrace($options = DEBUG_BACKTRACE_PROVIDE_OBJECT, $limit = 0)
    {
        global $trace;

        return is_array($trace)
            ? $trace
            : \debug_backtrace($options, $limit);
    }
}
