<?php

namespace WhizSid\ArrayBase\Query\Clauses;

use WhizSid\ArrayBase\AB\Table;
use WhizSid\ArrayBase\ABException;
use WhizSid\ArrayBase\KeepQuery;

class Join extends KeepQuery
{
    protected $mode;

    protected $on;

    protected $table;

    protected $availableModes = [AB_JOIN_INNER, AB_JOIN_LEFT, AB_JOIN_OUTER, AB_JOIN_LEFT];

    protected $defaultMode = AB_JOIN_INNER;

    public function __construct($mode = null)
    {
        if (!isset($mode)) {
            $mode = $this->defaultMode;
        }

        if (!in_array($mode, $this->availableModes)) {
            // <ABE15> \\
            throw new ABException('Invalid join method supplied.', 15);
        }
        $this->mode = array_search($mode, $this->availableModes) + 1;
    }

    /**
     * Setting an table to join.
     *
     * @param Table $table
     *
     * @return self
     */
    public function setTable($table)
    {
        $this->table = $table;
        $this->query->addTable($table);

        return $this;
    }

    /**
     * Creating the on clause.
     *
     * @param mixed $leftSide
     * @param mixed $operator
     * @param mixed $rightSide
     *
     * @return On
     */
    public function on($leftSide, $operator, $rightSide = null)
    {
        $on = new On($leftSide, $operator, $rightSide);
        $on->setQuery($this->query)->setAB($this->ab);
        $this->on = $on;

        return $on;
    }

    /**
     * Returning the joined table.
     *
     * @return Table
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * Returning the on clause.
     *
     * @return On
     */
    public function getOnCluase()
    {
        return $this->on;
    }

    /**
     * Returning the join mode.
     *
     * @return int one of AB_JOIN_INNER | AB_JOIN_LEFT | AB_JOIN_RIGHT | AB_JOIN_OUTER
     */
    public function getMode()
    {
        return $this->mode;
    }
}
