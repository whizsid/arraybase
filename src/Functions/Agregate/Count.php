<?php

namespace WhizSid\ArrayBase\Functions\Agregate;

use WhizSid\ArrayBase\Functions\Agregate;

class Count extends Agregate
{
    protected $name = 'count';

    protected function getReturn($arr)
    {
        return count($arr);
    }
}
