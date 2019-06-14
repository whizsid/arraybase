<?php

namespace WhizSid\ArrayBase\AB\Table;

use WhizSid\ArrayBase\AB\Traits\Aliasable;
use WhizSid\ArrayBase\AB\Traits\Indexed;
use WhizSid\ArrayBase\ABException;

class Column extends KeepTable
{
    use Aliasable,Indexed;

    const COMMENT_MAX_LENGTH = 100;
    /**
     * Column Type.
     *
     * @var DataType\DataType
     */
    protected $type;
    /**
     * Use When a column is auto increment.
     *
     * @var boolean
     */
    protected $autoIncrement = false;
    /**
     * Default value for the column.
     *
     * @var mixed
     */
    protected $default = null;
    /**
     * Is free to put null values in this column.
     *
     * @var boolean
     */
    protected $nullable = true;
    /**
     * Max length for a column in byte.
     *
     * @var integer
     */
    protected $maxLength;
    /**
     * Data type short aliases.
     *
     * @var string[]
     */
    protected $dataTypeAliases = [
        'date'   => 'Date',
        'integer'=> 'Integer',
        'varchar'=> 'VarChar',
    ];
    /**
     * You can also write comments to columns.
     *
     * @var string
     */
    protected $comment;

    /**
     * Creating a column to a table.
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Setting column type.
     *
     * @param string $str
     *
     * @throws ABException
     *
     * @return void
     */
    public function setType($str)
    {
        $this->validateName();

        if (!in_array($str, array_keys($this->dataTypeAliases))) {
            // <ABE3> \\
            throw new ABException('Invalid type "'.$str.'" for column "'.$this->name.'". Available types is '.implode(',', array_keys($this->dataTypeAliases)), 3);
        }
        $typeFullName = '\WhizSid\ArrayBase\AB\Table\DataType\\'.$this->dataTypeAliases[$str];

        $this->type = new $typeFullName();

        $this->setMaxLength();
    }

    /**
     * Getting the column type.
     *
     * @return DataType\DataType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Validating the column name.
     *
     * @throws ABException
     *
     * @return void
     */
    protected function validateName()
    {
        if (!isset($this->name)) {
            // <ABE4> \\
            throw new ABException('Please set a name to the column.', 4);
        }
    }

    /**
     * Validating type.
     *
     * @throws ABException
     *
     * @return void
     */
    protected function validateType()
    {
        if (!isset($this->type)) {
            // <ABE5> \\
            throw new ABException('Please set a type to the column.', 5);
        }
    }

    /**
     * Validating column required properties.
     *
     * @return void
     */
    public function validate()
    {
        $this->validateName();
        $this->validateType();
    }

    /**
     * Setting max length for the column.
     *
     * @param int $max
     */
    public function setMaxLength(int $max = null)
    {
        $this->validate();

        if (!$max) {
            $max = $this->type->getDefaultMaxLength();
        }

        $this->type->validateMaxLength($max);

        $this->maxLength = $max;
    }

    /**
     * Returning the max length for the column.
     *
     * @return int
     */
    public function getMaxLength()
    {
        return $this->maxLength;
    }

    /**
     * Setting a default value to column.
     *
     * @param mixed $data
     *
     * @return void
     */
    public function setDefaultValue($data)
    {
        $this->validate();

        $content = $data;
        if (is_callable($data)) {
            $content = $data();
        }

        $this->validateValue($content);

        $this->default = $data;
    }

    /**
     * Validating a given value by the column type.
     *
     * @param mixed $value
     *
     * @throws ABException
     *
     * @return void
     */
    public function validateValue($value)
    {
        if (!is_null($value) && !$this->type->validate($value)) {
            // <ABE6> \\
            throw new ABException('Invalid value provided to column. The value should be in "'.$this->type->getName().'" type.', 6);
        }
        if (!is_null($value) && $this->maxLength < strlen($value)) {
            // <ABE7> \\
            throw new ABException('Supplied value is greater than the max length.', 7);
        }
        if (!$this->nullable && is_null($value)) {
            // <ABE8> \\
            throw new ABException('Empty value supplied to non nullable column.', 8);
        }
    }

    /**
     * Getting default value for column.
     *
     * @return mixed
     */
    public function getDefaultValue()
    {
        if (is_callable($this->default)) {
            return $this->default();
        } else {
            return $this->default;
        }
    }

    /**
     * Setting the column to auto incrementing.
     *
     * @param bool $ai
     *
     * @throws ABException
     *
     * @return void
     */
    public function setAutoIncrement(bool $ai = true)
    {
        $this->validate();

        // <ABE9> \\
        if ($this->type->getName() !== 'integer') {
            throw new ABException('We are allowing auto increment only for integer type columns', 9);
        }
        $this->autoIncrement = $ai;
    }

    /**
     * Determine the column has set to auto increment.
     *
     * @return boolean
     */
    public function isAutoIncrement()
    {
        return $this->autoIncrement;
    }

    /**
     * Setting nullable to columns.
     *
     * @param bool $nl
     *
     * @throws ABException
     *
     * @return void
     */
    public function setNullable(bool $nl = true)
    {
        $this->validate();

        // <ABE10> \\
        if ($this->autoIncrement) {
            throw new ABException('We are not allowing to set nullable on auto incrementing columns', 10);
        }
        $this->nullable = $nl;
    }

    /**
     * Determine the weather the column has nullable attribute or not.
     *
     * @return boolean
     */
    public function isNullable()
    {
        return $this->nullable;
    }

    /**
     * Write a comment to the column.
     *
     * @param string $cmnt
     */
    public function writeComment($cmnt)
    {
        $this->validate();

        // <ABE11> \\
        if (strlen($cmnt) > self::COMMENT_MAX_LENGTH) {
            throw new ABException('The comment max character length is '.self::COMMENT_MAX_LENGTH.'. Please summerize your comment.', 11);
        }
        $this->comment = substr($cmnt, 0, self::COMMENT_MAX_LENGTH);
    }

    /**
     * Getting the wrote comment.
     *
     * @return string
     */
    public function getComment()
    {
        $this->validate();

        return $this->comment;
    }

    /**
     * Reterning the full name with table name.
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->getTable()->getName().'.'.$this->getName();
    }
}
