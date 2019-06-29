<?php

namespace WhizSid\ArrayBase\AB\Table\DataType;

interface DataType
{
    /**
     * Validating a cell value before update or insert.
     *
     * @param mixed $data
     *
     * @return bool
     */
    public function validate($data);

    /**
     * Formating a value when passed.
     *
     * @param mixed $value
     *
     * @return mixed
     */
    public function format($value);

    /**
     * Returning the data type name.
     *
     * @return string
     */
    public function getName();

    /**
     * Returning default max length for the data type.
     *
     * @return int
     */
    public function getDefaultMaxLength();

    /**
     * Validating the max length for the data type.
     *
     * @param int $max
     */
    public function validateMaxLength($max);
}
