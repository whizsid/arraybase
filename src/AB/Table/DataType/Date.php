<?php

namespace WhizSid\ArrayBase\AB\Table\DataType;

use WhizSid\ArrayBase\ABException;

class Date implements DataType
{
    /**
     * @inherit
     *
     * {@inheritdoc}
     * {@inherit}
     */
    public function validate($date)
    {
        return (bool) strtotime($date);
    }

    /**
     * @inherit
     *
     * {@inheritdoc}
     * {@inherit}
     */
    public function format($date)
    {
        return date('Y-m-d', strtotime($date));
    }

    /**
     * @inherit
     *
     * {@inheritdoc}
     * {@inherit}
     */
    public function getName()
    {
        return 'date';
    }

    /**
     * @inherit
     *
     * {@inheritdoc}
     * {@inherit}
     */
    public function getDefaultMaxLength()
    {
        return 8;
    }

    /**
     * @inherit
     *
     * {@inheritdoc}
     * {@inherit}
     */
    public function validateMaxLength($max)
    {
        // <ABE12> \\
        if ($max > 19) {
            throw new ABException('The given length is exceed the available max length.', 12);
        }
    }
}
