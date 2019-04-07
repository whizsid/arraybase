<?php
namespace WhizSid\ArrayBase\Query\Traits;

trait Limitable {
    protected $limit;

    protected $offset;
    /**
     * Limiting Results
     *
     * @param integer $limit
     * @param integer $offset
     * @return self
     */
    public function limit($limit,$offset=0){
        $this->limit = $limit;
        $this->offset = $offset;
        return $this;
    }
}