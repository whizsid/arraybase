<?php
namespace WhizSid\ArrayBase\AB\Query\Traits\Joinable;

use WhizSid\ArrayBase\AB\Data\Set;
use WhizSid\ArrayBase\AB\Query\Clause\On;

abstract class Exec{
    /**
     * The first  data set to join
     *
     * @var Set
     */
    protected $dataSet;
    /**
     * Second data set to join
     *
     * @var Set
     */
    protected $dataSet2;
    /**
     * On clause in join clause
     *
     * @var On
     */
    protected $onClause;

    public function __construct($dataSet,$dataSet2,$onClause){
        $this->dataSet =$dataSet;
        $this->dataSet2 = $dataSet2;
        $this->onClause = $onClause;
    }
}