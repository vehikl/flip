<?php

namespace Vehikl\Flip;

class UnresolvableDependencies extends \DomainException
{
    protected $message = "The Flip DefaultResolver is unable to resolve method dependencies.";
}
