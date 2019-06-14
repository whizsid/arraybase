<?php

namespace WhizSid\ArrayBase\Functions;

class Concat extends ABFunction
{
    /**
     * Column names or strings to concat.
     *
     * @var mixed[]
     */
    protected $concats = [];
    /**
     * Function name.
     *
     * @var string
     */
    protected $name = 'concat';

    /**
     * Parsing variables to concat.
     *
     * @param mixed ...$args
     */
    public function __construct(...$args)
    {
        $this->concats = $args;

        $this->validate();
    }

    /**
     * Validating arguments.
     *
     * @return void
     */
    public function validate()
    {
        foreach ($this->concats as $key => $concat) {
            $this->validateBasicArgument($concat);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function execute(int $rowId = 0)
    {
        $concated = '';

        foreach ($this->concats as $key => $concat) {
            $parsedValue = $this->parseArgument($concat, $rowId);

            if (!$parsedValue) {
                $parsedValue = '';
            }

            $concated .= $parsedValue;
        }

        return $concated;
    }
}
