<?php

namespace WhizSid\ArrayBase\AB\DataSet\Row;

use WhizSid\ArrayBase\AB\Traits\Indexed;

class Cell extends KeepRow
{
    use Indexed;
    /**
     * Value to cell.
     *
     * @var mixed
     */
    protected $value;

    /**
     * Returning the value.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Setting value.
     *
     * @param mixed
     */
    public function setValue($value)
    {
        $this->value = $value;
    }
}
