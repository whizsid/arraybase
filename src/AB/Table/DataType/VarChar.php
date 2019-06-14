<?php

namespace WhizSid\ArrayBase\AB\Table\DataType;

use WhizSid\ArrayBase\ABException;

class VarChar implements DataType
{
    /**
     * @inherit
     *
     * {@inheritdoc}
     * {@inherit}
     */
    public function validate($str)
    {
        return is_string($str);
    }

    /**
     * @inherit
     *
     * {@inheritdoc}
     * {@inherit}
     */
    public function format($str)
    {
        return (string) $str;
    }

    /**
     * @inherit
     *
     * {@inheritdoc}
     * {@inherit}
     */
    public function getName()
    {
        return 'varchar';
    }

    /**
     * @inherit
     *
     * {@inheritdoc}
     * {@inherit}
     */
    public function getDefaultMaxLength()
    {
        return 45;
    }

    /**
     * @inherit
     *
     * {@inheritdoc}
     * {@inherit}
     */
    public function validateMaxLength($max)
    {
        // <ABE14> \\
        if ($max > 500) {
            throw new ABException('The given length is exceed the available max length.', 14);
        }
    }
}
