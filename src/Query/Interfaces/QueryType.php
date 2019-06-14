<?php

namespace WhizSid\ArrayBase\Query\Interfaces;

use WhizSid\ArrayBase\Query\Objects\ReturnSet;

interface QueryType
{
    /**
     * Executing the query type.
     *
     * @return ReturnSet
     */
    public function execute();
}
