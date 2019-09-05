<?php

namespace WhizSid\ArrayBase\AB\Table\DataType;

use WhizSid\ArrayBase\ABException;

class Integer implements DataType
{
    /**
     * @inherit
     *
     * {@inheritdoc}
     * {@inherit}
     */
    public function validate($int)
    {
        return (bool) is_numeric($int);
    }

    /**
     * @inherit
     *
     * {@inheritdoc}
     * {@inherit}
     */
    public function format($int)
    {
        return round($int);
    }

    /**
     * @inherit
     *
     * {@inheritdoc}
     * {@inherit}
     */
    public function getName()
    {
        return 'integer';
    }

    /**
     * @inherit
     *
     * {@inheritdoc}
     * {@inherit}
     */
    public function getDefaultMaxLength()
    {
        return 140;
    }

    /**
     * @inherit
     *
     * {@inheritdoc}
     * {@inherit}
     */
    public function validateMaxLength($max)
    {
        // <ABE13> \\
        if ($max > 256) {
            throw new ABException('The given length is exceed the available max length.', 13);
        }
    }
}
