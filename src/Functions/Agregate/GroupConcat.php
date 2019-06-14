<?php

namespace WhizSid\ArrayBase\Functions\Agregate;

use WhizSid\ArrayBase\Functions\Agregate;

class GroupConcat extends Agregate
{
    protected $name = 'group_concat';
    /**
     * Separator to join column values.
     *
     * @var string
     */
    protected $separator = ', ';

    /**
     * Setter for the separator.
     *
     * @param string $sprtr
     *
     * @return self
     */
    public function separatedBy($sprtr)
    {
        $this->separator = $sprtr;

        return $this;
    }

    protected function getReturn($arr)
    {
        return implode($this->separator, $arr);
    }
}
