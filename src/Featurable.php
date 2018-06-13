<?php

namespace Vehikl\Flip;

trait Featurable
{
    protected function flip()
    {
        return new Flip($this, $this->features);
    }
}
