<?php

namespace Vehikl\Flip;

class Caller
{
    /**
     * Guess and return the object a feature is mixed into
     *
     * @throws \LogicException
     * @return object
     */
    public static function guess(): object
    {
        foreach (debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 5) as $trace) {
            if (! isset($trace['object']) || in_array(get_class($trace['object']), [Feature::class, static::class])) {
                continue;
            }

            return $trace['object'];
        }

        throw new \LogicException('No caller found.');
    }
}
