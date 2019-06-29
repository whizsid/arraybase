<?php

namespace WhizSid\ArrayBase;

/**
 * This class will keeping the parent query class.
 */
class KeepQuery extends KeepAB
{
    /**
     * Parent query.
     *
     * @var Query
     */
    protected $query;

    /**
     * Returning the parent query.
     *
     * @return Query
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Setting the parent query.
     *
     * @param Query $query
     *
     * @return self
     */
    public function setQuery($query)
    {
        $this->query = $query;

        return $this;
    }
}
