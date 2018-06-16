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
    public static function guess()
    {
        foreach (debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 10) as $trace) {
            if (self::shouldIgnore($trace['object'] ?? null)) {
                continue;
            }

            return $trace['object'];
        }

        throw new \LogicException('No caller found.');
    }

    /**
     * Determine if the guesser should ignore the passed object from the
     * stack trace.
     *
     * @param $object
     *
     * @return bool
     */
    private static function shouldIgnore($object)
    {
        return $object == null || $object instanceof Feature;
    }
}
