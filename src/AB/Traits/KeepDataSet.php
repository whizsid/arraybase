<?php

namespace WhizSid\ArrayBase\AB\Traits;

use WhizSid\ArrayBase\AB\DataSet;

trait KeepDataSet
{
    /**
     * DataSet for the given instance.
     *
     * @var DataSet
     */
    protected $dataSet;

    /**
     * Setting data set.
     *
     * @param DataSet $set
     *
     * @return self
     */
    public function setDataSet(DataSet $set)
    {
        $this->dataSet = $set;

        return $this;
    }

    /**
     * Returning the data set for the given instance.
     *
     * @return DataSet
     */
    public function getDataSet()
    {
        return $this->dataSet;
    }
}
