<?php

namespace Vehikl\Flip\Tests;

use Vehikl\Flip\Featurable;

class SomeClass
{
    use Featurable;

    protected $features = [
        SomeFeature::class,
        SomeOtherFeature::class,
    ];

    public function go(): string
    {
        return 'going!';
    }

    public function someToggledMethod(): string
    {
        return $this->flip()->someOtherToggle();
    }
}
